<?php

namespace App\Http\Controllers;

use App\DataTables\GroupDataTable;
use App\Document;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Repositories\PermissionRepository;
use App\Repositories\UserRepository;
use App\Tag;
use App\User;
use Flash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class GroupController extends Controller
{
    /** @var  UserRepository */
    private $userRepository;

    /** @var PermissionRepository */
    private $permissionRepository;

    public function __construct(UserRepository $userRepo,
                                PermissionRepository $permissionRepository)
    {
        $this->userRepository = $userRepo;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the User.
     *
     * @param UserDataTable $userDataTable
     * @return Response
     */
    public function index(GroupDataTable $groupDataTable)
    {
        $this->authorize('user manage permission','update users');
        return $groupDataTable->render('groups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('user manage permission','update users');
        $tags = Tag::pluck('name', 'id');
        $users = User::where('id','!=',1)->pluck('name', 'id');
        return view('groups.create', compact('tags','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGroupRequest $request)
    {
        $this->authorize('user manage permission','update users');
        $usersId = $request->users ?? [];
        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description
        ]);
        foreach($usersId as $userId){
            $user = User::find($userId);
            $user->assignRole($role);
        }
        $role->syncPermissions($this->mapInputToPermissions($request->all()));
        Flash::success('Groupe sauvegardé avec succès.');
        return redirect(route('groups.index'));
    }

    private function mapInputToPermissions($input)
    {
        $permissions = $input['global_permissions'] ?? [];
        foreach ($input['tag_permissions'] ?? [] as $tag_permission) {
            foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
                if (isset($tag_permission[$perm]))
                    $permissions[] = $perm_key . $tag_permission['tag_id'];
            }
        }
        return $permissions;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Role::find($id);
        $this->authorize('user manage permission','update users');

        if (empty($group)) {
            Flash::error('Groupe non trouvée');

            return redirect(route('groups.index'));
        }

        $tmpTagIds = groupTagsPermissions($group->permissions);
        $tags = Tag::whereIn('id', array_column($tmpTagIds, 'tag_id'))->get();

        $tmpDocIds = groupDocumentsPermissions($group->permissions);

        $documents = Document::whereIn('id', array_column($tmpDocIds, 'doc_id'))->get();

        $globalPermissions = $this->permissionRepository->getGlobalPermissionsModelWiseForGroup($group);

        return view('groups.show', compact('group', 'tags', 'documents','globalPermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('user manage permission','update users');
        $users = User::where('id','!=',1)->pluck('name', 'id');
        $group = Role::find($id);
        $tags = Tag::pluck('name', 'id');
        if (empty($group)) {
            Flash::error('Groupe non trouvée');

            return redirect(route('users.index'));
        }
        return view('groups.edit',compact('group','tags','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroupRequest $request, $id)
    {
        $this->authorize('user manage permission','update users');
        $role = Role::find($id);
        $newusersId = $request->users ?? [];
        $usersWithRole = $role->users;
        foreach ($usersWithRole as $user) {
            $user->removeRole($role);
        }
        
        foreach($newusersId as $userId){
            $user = User::find($userId);
            $user->assignRole($role);
        }
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();
        $role->syncPermissions($this->mapInputToPermissions($request->all()));
        Flash::success('Groupe mis à jour avec succès.');
        return redirect(route('groups.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        $this->authorize('user manage permission','update users');
        if (empty($role)) {
            Flash::error('Groupe non trouvée');
            return redirect(route('users.index'));
        }
        $role->syncPermissions([]);
        $users = $role->users;
        foreach ($users as $user) {
            $user->removeRole($role);
        }
        $role->delete();
        Flash::success('Groupe supprimé avec succès.');
        return redirect(route('groups.index'));
    }
}
