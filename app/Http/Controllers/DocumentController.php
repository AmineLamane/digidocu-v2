<?php

namespace App\Http\Controllers;

use App\CustomField;
use App\Document;
use App\File;
use App\FileType;
use App\Http\Requests\CreateDocumentRequest;
use App\Http\Requests\CreateFilesRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Repositories\CustomFieldRepository;
use App\Repositories\DocumentRepository;
use App\Repositories\FileTypeRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\TagRepository;
use App\Tag;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Laracasts\Flash\Flash;
use Spatie\Permission\Models\Permission;

class DocumentController extends Controller
{
    /** @var  TagRepository */
    private $tagRepository;

    /** @var DocumentRepository */
    private $documentRepository;

    /** @var CustomFieldRepository */
    private $customFieldRepository;

    /** @var FileTypeRepository */
    private $fileTypeRepository;

    /** @var PermissionRepository $permissionRepository */
    private $permissionRepository;

    public function __construct(TagRepository $tagRepository,
                                DocumentRepository $documentRepository,
                                CustomFieldRepository $customFieldRepository,
                                FileTypeRepository $fileTypeRepository,
                                PermissionRepository $permissionRepository)
    {
        $this->tagRepository = $tagRepository;
        $this->documentRepository = $documentRepository;
        $this->customFieldRepository = $customFieldRepository;
        $this->fileTypeRepository = $fileTypeRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Document::class);
        $user = Auth::user();
        //get current tag
        $currenttag = null;
        $tagId = $request->input('tags');
        if($request->has('tags')){
            $currenttag = Tag::findOrFail($tagId);
            $this->authorize('viewtag', $currenttag);
        }
        //initializing the breadcrumb
        $breadcrumb = [];
        //filling the breadcrumb
        if ($currenttag) {
            $breadcrumb = $this->generateBreadcrumb($currenttag);
        }
        $ancestors = [];
        $ancestorstocheck = Tag::where('parent_id', $tagId)->get();
        // Generate an array of permissions to check for each tag.
        $permissionstocheck = Tag::selectRaw('CONCAT("read documents in tag ", id) as permissions, id')
            ->whereIn('id', $ancestorstocheck->pluck('id'))
            ->pluck('permissions', 'id')
            ->toArray();
        // Generate an array of permissions to check for each document.
        $documentspermissions = Document::selectRaw('CONCAT("read document ", documents.id) as permissions, tags.id as tag_id')
            ->join('documents_tags', 'documents.id', '=', 'documents_tags.document_id')
            ->join('tags', 'documents_tags.tag_id', '=', 'tags.id')
            ->whereIn('tags.id', $ancestorstocheck->pluck('id'))
            ->pluck('permissions', 'tag_id')
            ->toArray();
        // Check read permission in any tag in ancestorstocheck and its child.
        foreach ($permissionstocheck as $id => $permission) {
            if (Auth::user()->can($permission) && !in_array($id, array_column($ancestors, 'id'))) {
                $ancestors[] = Tag::find($id);
            }
        }
        foreach ($documentspermissions as $id => $permission) {
            if (Auth::user()->can($permission) && !in_array($id, array_column($ancestors, 'id'))) {
                $ancestors[] = Tag::find($id);
            }
        }

        foreach ($ancestorstocheck as $ancestor) {
            $children = $ancestor->children;
            $this->checkChildPermissions($children, $ancestor, $ancestors);
        }
        
        foreach ($ancestorstocheck as $tag) {
            $tagPermissions = [];
            $currentTag = $tag;
            while ($currentTag) {
                $tagPermissions[] = 'read documents in tag ' . $currentTag->id;
                $currentTag = $currentTag->parent; // Move to the parent tag.
            }
            if ($user->hasAnyPermission($tagPermissions)) {
                if (!in_array($tag->id, array_column($ancestors, 'id'))) {
                    $ancestors[] = $tag;
                }
            }
        }
        
        $tags = $tagId ? [$tagId] : [];
        array_push($tags,$request->tags);
        $documents = $this->documentRepository->searchDocuments(
            $request->get('search'),
            $tags,
            $request->get('status')
        );
        return view('documents.index', compact('documents', 'ancestors','currenttag','breadcrumb'));
    }

    private function checkChildPermissions($children, $ancestor, &$ancestors) {
        if (!$children->isEmpty()) {
            foreach ($children as $child) {
                $permissionstocheck = Tag::selectRaw('CONCAT("read documents in tag ", id) as permissions, id')
                    ->where('id', $child->id)
                    ->pluck('permissions', 'id')
                    ->toArray();
                $documentspermissions = Document::selectRaw('CONCAT("read document ", id) as permissions, id')
                ->whereHas('tags', function ($query) use ($child) {
                    $query->where('id', $child->id);
                })->pluck('permissions', 'id')
                ->toArray();
                $permissionstocheck+= $documentspermissions;
                foreach ($permissionstocheck as $id => $permission) {
                    if (Auth::user()->can($permission) && !in_array($ancestor->id, array_column($ancestors, 'id'))) {
                        $ancestors[] = $ancestor;
                    }
                }
    
                $this->checkChildPermissions($child->children, $ancestor, $ancestors);
            }
        }
    }

    private function generateBreadcrumb($tag)
    {
        $breadcrumb = [];

        while ($tag->parent) {
            $breadcrumb[] = [$tag->parent->id => $tag->parent->name];
            $tag = $tag->parent;
        }

        return array_reverse($breadcrumb);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $tag = Tag::findOrFail($request->tag);
        $this->authorize('create', [Document::class, $tag]);
        $tags = $this->tagRepository->all();
        $gettag = $tag;
        $currenttag = $tag;
        $parents = [];
        $breadcrumb = $this->generateBreadcrumb($currenttag);
        while ($currenttag) {
            $currenttag = $currenttag->parent?? null;
            if($currenttag){
                $parents[]= $currenttag->id;
            }
        }
        $customFields = $this->customFieldRepository->getForModel('documents');
        return view('documents.create', compact('tags', 'customFields','gettag','parents', 'breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDocumentRequest $request)
    {
        $data = $request->all();
        $data['created_by'] = Auth::id();
        $data['status'] = config('constants.STATUS.PENDING');
        $this->authorize('store', [Document::class, $data['tags']]);

        $document = $this->documentRepository->createWithTags($data);
        Flash::success(ucfirst(config('settings.document_label_singular')) . " Sauvegardé avec succès!");
        $document->newActivity(ucfirst(config('settings.document_label_singular')) . " Crée");

        //create permission for new document
        foreach (config('constants.DOCUMENT_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $document->id]);
        }

        if ($request->has('savnup')) {
            return redirect()->route('documents.files.create', $document->id);
        }
        return redirect()->route('documents.index',['tags' => $data['tags'][0]]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /** @var Document $document */
        $document = $this->documentRepository
            ->getOneEagerLoaded($id,['files', 'files.fileType', 'files.createdBy', 'activities', 'activities.createdBy', 'tags']);
        if (empty($document)) {
            abort(404);
        }
        $this->authorize('view', $document);

        $missigDocMsgs = $this->documentRepository->buildMissingDocErrors($document);
        $gettag = $document->tags[0];
        $breadcrumb = $this->generateBreadcrumb($gettag);
        $dataToRet = compact('document', 'missigDocMsgs', 'breadcrumb');
        if (auth()->user()->can('user manage permission')) {
            $users = User::where('id', '!=', 1)->get();
            $thisDocPermissionUsers = $this->permissionRepository->getUsersWiseDocumentLevelPermissionsForDoc($document);
            //Tag Level permission
            $tagWisePermList = $this->permissionRepository->getTagWiseUsersPermissionsForDoc($document);
            //Global Permission
            $globalPermissionUsers = $this->permissionRepository->getGlobalPermissionsForDoc($document);

            $dataToRet = array_merge($dataToRet, compact('users', 'thisDocPermissionUsers', 'tagWisePermList', 'globalPermissionUsers'));
        }
        
        
        return view('documents.show', $dataToRet);
    }

    public function storePermission($id, Request $request)
    {
        abort_if(!auth()->user()->can('user manage permission'), 403, 'Cette action n\'est pas autorisée .');
        $input = $request->all();
        $user = User::findOrFail($input['user_id']);
        $doc_permissions = $input['document_permissions'];
        $document = Document::findOrFail($id);
        $this->permissionRepository->setDocumentLevelPermissionForUser($user,$document,$doc_permissions);
        Flash::success(ucfirst(config('settings.document_label_singular')) . " Permission allouée à l'utilisateur avec succès!");
        return redirect()->back();
    }

    public function deletePermission($documentId, $userId)
    {
        abort_if(!auth()->user()->can('user manage permission'), 403, 'Cette action n\'est pas autorisée.');
        $user = User::findOrFail($userId);
        $document = Document::findOrFail($documentId);
        $this->permissionRepository->deleteDocumentLevelPermissionForUser($document,$user);
        Flash::success(ucfirst(config('settings.document_label_singular')) . " Permission supprimée de l'utilisateur avec succès");
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $document = Document::with('tags')->findOrFail($id);
        $this->authorize('edit', $document);
        $gettag = $document->tags[0];
        $tags = Tag::all();
        $breadcrumb = $this->generateBreadcrumb($gettag);
        $customFields = $this->customFieldRepository->getForModel('documents');
        return view('documents.edit', compact('tags', 'customFields', 'document','gettag','breadcrumb'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDocumentRequest $request, $id)
    {
        $document = Document::findOrFail($id);
        $data = $request->all();
        $this->authorize('update', [$document, $data['tags']]);
        $this->documentRepository->updateWithTags($data,$document);
        $document->newActivity(ucfirst(config('settings.document_label_singular')) . " Mis à jour");
        Flash::success(ucfirst(config('settings.document_label_singular')) . " Mis à jour avec succès!");
        if ($request->has('savnup')) {
            return redirect()->route('documents.files.create', $document->id);
        }
        return redirect()->route('documents.show',$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Document $document)
    {
        $this->authorize('delete', $document);
        $document->newActivity(ucfirst(config('settings.document_label_singular')) . " Supprimé");
        $this->documentRepository->deleteWithFiles($document,true);
        Flash::success(ucfirst(config('settings.document_label_singular')) . " Supprimé avec succès!");
        return redirect()->route('documents.index',['tags'=> $request->tags]);
    }

    public function verify($id, Request $request)
    {
        $document = Document::findOrFail($id);
        $this->authorize('verify', $document);
        $action = $request->get('action');
        $comment = $request->get('vcomment',"");
        if (!empty($comment)) {
            $comment = " avec commentaire: <i>" . $comment . "</i>";
        }
        $msg = "";
        if ($action == 'approve') {
            $this->documentRepository->approveDoc($document);
            $msg = "Approuvée";
        } elseif ($action == 'reject') {
            $this->documentRepository->rejectDoc($document);
            $msg = "Refusée";
        } else {
            abort(404);
        }
        $document->newActivity(ucfirst(config('settings.document_label_singular')) . " $msg $comment");

        Flash::success(ucfirst(config('settings.document_label_singular')) . " $msg avec succès!");
        return redirect()->back();
    }

    public function showUploadFilesUi($id)
    {
        $document = Document::find($id);
        if(empty($document)){
            Flash::error("Veuillez créer au moins un".config('settings.document_label_singular')." avant d'uploader des ".config('settings.file_label_plural'));
            return redirect()->route('documents.index');
        }
        $this->authorize('update', [$document, $document->tags->pluck('id')]);
        $fileTypes = FileType::pluck('name', 'id');
        $customFields = $this->customFieldRepository->getForModel('files');
        return view('documents.file_upload', compact('document', 'fileTypes', 'customFields'));
    }

    public function storeFiles($id, CreateFilesRequest $request)
    {
        $document = Document::findOrFail($id);
        $this->authorize('update', [$document, $document->tags->pluck('id')]);
        $filesData = $request->all('files')['files'] ?? [];
        /* Prepare final data */
        $filesData = $this->prepareFilesData($filesData);
        $this->documentRepository->saveFilesWithDoc($filesData, $document);
        $nombreFichiers = count($filesData);
        $labelFichier = ($nombreFichiers === 1) ? config('settings.file_label_singular') : config('settings.file_label_plural');
        $document->newActivity($nombreFichiers . " Nouveau" . ($nombreFichiers === 1 ? " " : "x ") . ucfirst($labelFichier) . " téléchargé(s) dans " . ucfirst(config('settings.document_label_singular')));
        Flash::success(ucfirst($labelFichier) . " uploadée avec succès!");
        if (!$request->ajax()) {
            return redirect()->route('documents.show', ['id' => $document->id]);
        } else {
            return ["msg" => "Success"];
        }
    }

    private function prepareFilesData($filesData){
        $imageVariants = explode(',', config('settings.image_files_resize'));
        foreach ($filesData as $i => $fileData) {
            /** @var UploadedFile $file */
            $file = $filesData[$i]['file'];
            $filePath = $file->store('files/original');
            if (isImage($file->getMimeType())) {
                /*Image intervention resize*/
                foreach ($imageVariants as $imageVariant) {
                    $resizeSavePath = "app/files/$imageVariant/";
                    if (!file_exists(storage_path($resizeSavePath))) {
                        mkdir(storage_path($resizeSavePath), 0755, true);
                    }
                    $imageIntervention = Image::make(storage_path('app/' . $filePath));
                    $imageIntervention->resize($imageVariant, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(storage_path($resizeSavePath . $file->hashName()));
                }

                //create thumb
                $thumbPath = "app/files/thumb/";
                if (!file_exists(storage_path($thumbPath))) {
                    mkdir(storage_path($thumbPath), 0755, true);
                }
                Image::make(storage_path('app/' . $filePath))
                    ->resize(193, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(storage_path($thumbPath . $file->hashName()));
            }

            $filesData[$i]['custom_fields'] = json_encode($filesData[$i]['custom_fields'] ?? []);
            $filesData[$i]['file'] = $file->hashName();
            $filesData[$i]['created_by'] = Auth::id();
            $filesData[$i]['created_at'] = now();
            $filesData[$i]['updated_at'] = now();
        }

        return $filesData;
    }

    public function deleteFile($id)
    {
        $file = File::findOrFail($id);
        $this->authorize('delete', $file->document);
        $file->document->newActivity($file->name . " Supprimé depuis " . ucfirst(config('settings.document_label_singular')));
        $this->documentRepository->deleteFile($file);
        Flash::success(ucfirst(config('settings.file_label_singular')) . " Supprimé avec succès!");
        return redirect()->back();
    }
}
