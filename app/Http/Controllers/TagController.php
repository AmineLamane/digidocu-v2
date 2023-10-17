<?php

namespace App\Http\Controllers;

use App\CustomField;
use App\DataTables\TagDataTable;
use App\Http\Requests\CreateTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Repositories\PermissionRepository;
use App\Repositories\TagRepository;
use App\Tag;
use App\User;
use Flash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Response;
use Spatie\Permission\Models\Permission;

class TagController extends AppBaseController
{
    /** @var  TagRepository */
    private $tagRepository;
    /** @var PermissionRepository */
    private $permissionRepository;

    public function __construct(TagRepository $tagRepo,
                                PermissionRepository $permissionRepository)
    {
        $this->tagRepository = $tagRepo;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the Tag.
     *
     * @param TagDataTable $tagDataTable
     * @return Response
     */
    public function index(TagDataTable $tagDataTable)
    {
        $this->authorize('viewAny', Tag::class);
        return $tagDataTable->render('tags.index');
    }

    /**
     * Show the form for creating a new Tag.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', Tag::class);
        $tags = Tag::pluck('name','id')->toArray();
        $tags = [null => null] + $tags;
        $customFields = CustomField::where('model_type', 'tags')->get();
        return view('tags.create', compact(['customFields','tags']));
    }

    /**
     * Store a newly created Tag in storage.
     *
     * @param CreateTagRequest $request
     *
     * @return Response
     */
    public function store(CreateTagRequest $request)
    {
        $this->authorize('create', Tag::class);
        $input = $request->all();
        $input['created_by'] = Auth::id();
        $tag = $this->tagRepository->create($input);

        //create permissions for new tag
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        Flash::success(ucfirst(config('settings.tags_label_singular')) . " sauvegardée avec succès!");

        return redirect(route('tags.index'));
    }

    /**
     * Display the specified Tag.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $tag = $this->tagRepository->find($id);
        $this->authorize('view', $tag);

        if (empty($tag)) {
            Flash::error(ucfirst(config('settings.tags_label_singular')) . ' non trouvée');

            return redirect(route('tags.index'));
        }
        $tagWisePermList = null;
        $globalPermissionUsers = null;
        if (auth()->user()->can('user manage permission')) {
            //Tag wise permission
            $tagWisePermList = $this->permissionRepository->getUserWisePermissionsByTag($tag);

            //Global Permission
            $globalPermissionUsers = User::permission(array_keys(config('constants.GLOBAL_PERMISSIONS.DOCUMENTS')))->get();
        }

        return view('tags.show', compact('tag', 'tagWisePermList', 'globalPermissionUsers'));
    }

    /**
     * Show the form for editing the specified Tag.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $tag = $this->tagRepository->find($id);
        $this->authorize('update', $tag);
        $customFields = CustomField::where('model_type', 'tags')->get();
        $tags = Tag::pluck('name','id')->except('id',$id)->toArray();
        $tags = [null => null] + $tags;
        if (empty($tag)) {
            Flash::error(ucfirst(config('settings.tags_label_singular')) . ' non trouvée');

            return redirect(route('tags.index'));
        }

        return view('tags.edit',compact('tag','tags','customFields'));
    }

    /**
     * Update the specified Tag in storage.
     *
     * @param int $id
     * @param UpdateTagRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTagRequest $request)
    {
        $tag = $this->tagRepository->find($id);
        $this->authorize('update', $tag);

        if (empty($tag)) {
            Flash::error(ucfirst(config('settings.tags_label_singular')) . ' non trouvée');

            return redirect(route('tags.index'));
        }

        $tag = $this->tagRepository->update($request->all(), $id);

        Flash::success(ucfirst(config('settings.tags_label_singular')) . ' mise à jour avec succès.');

        return redirect(route('tags.index'));
    }

    /**
     * Remove the specified Tag from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $tag = $this->tagRepository->find($id);
        $this->authorize('delete', $tag);

        if (empty($tag)) {
            Flash::error(ucfirst(config('settings.tags_label_singular')) . ' non trouvée');
            return redirect(route('tags.index'));
        }
        if($tag->children->count() > 0){
            Flash::error('Cette ' . config('settings.tags_label_singular') . ' a des sous ' . config('settings.tags_label_plural') . '. Veuillez les supprimer avant de réessayez');
            return redirect(route('tags.index'));
        }
        try {
            $this->tagRepository->deleteWithPermissions($tag);
        } catch (QueryException $e) {
            Flash::error('Cette ' . config('settings.tags_label_singular') . ' a des ' . config('settings.document_label_plural') . '. Veuillez les supprimer avant de réessayez');
            return redirect(route('tags.index'));
        }

        Flash::success(ucfirst(config('settings.tags_label_singular')) . ' supprimée avec succès.');
        return redirect(route('tags.index'));
    }
}
