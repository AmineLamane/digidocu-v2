<?php

namespace App\Policies;

use App\Document;
use App\Tag;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class TagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tags.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        if ($user->can('read tags')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can view the tag.
     *
     * @param \App\User $user
     * @param \App\Tag $tag
     * @return mixed
     */
    public function view(User $user, Tag $tag)
    {
        if ($user->can('create tags')) {
            return true;
        } else {
            return false;
        }
        
    }
    public function viewtag(User $user, Tag $tag){
        if ($user->can('read documents')) {
            return true;
        }
        // check permission in parent tags
        $tagPermissions = [];
        $currentTag = $tag;
        while ($currentTag) {
            $tagPermissions[] = 'read documents in tag ' . $currentTag->id;
            $currentTag = $currentTag->parent; // Move to the parent tag.
        }
        if ($user->hasAnyPermission($tagPermissions)) {
                return true;
        }
        $documentspermissions = Document::selectRaw('CONCAT("read document ", id) as permissions, id')
            ->whereHas('tags', function ($query) use ($tag) {
                $query->where('id', $tag->id);
            })->pluck('permissions', 'id')
            ->toArray();
        // Check read permission in any tag in ancestorstocheck and its child.
        $documentspermissions;
        foreach ($documentspermissions as $id => $permission) {
            if (Auth::user()->can($permission)) {
                return true;
            }
        }
        // check permission in children tags
        $children = $tag->children;
        return $this->checkChildPermissions($children, $tag);
    }
    private function checkChildPermissions($children, $tag) {
        $k = 0;
        if (!$children->isEmpty()) {
            foreach ($children as $child) {
                $permissionstocheck = Tag::selectRaw('CONCAT("read documents in tag ", id) as permissions, id')
                    ->where('id', $child->id)
                    ->pluck('permissions')
                    ->toArray();
                    $documentspermissions = Document::selectRaw('CONCAT("read document ", id) as permissions, id')
                    ->whereHas('tags', function ($query) use ($child) {
                        $query->where('id', $child->id);
                    })->pluck('permissions', 'id')
                    ->toArray();
                    $permissionstocheck+= $documentspermissions;
                    foreach ($permissionstocheck as $id => $permission) {
                        if (Auth::user()->hasAnyPermission($permission)) {
                            return true;
                        }
                    }
                $this->checkChildPermissions($child->children, $tag);
            }
        }else{
            return false;
        }
    }

    public function viewtagorparent(User $user, Tag $tag){
        if ($user->can('read documents')) {
            return true;
        }
        $documentspermissions = Document::selectRaw('CONCAT("read document ", id) as permissions, id')
        ->whereHas('tags', function ($query) use ($tag) {
            $query->where('id', $tag->id);
        })->pluck('permissions', 'id')
        ->toArray();
        foreach ($documentspermissions as $id => $permission) {
            if (Auth::user()->hasAnyPermission($permission)) {
                return true;
            }
        }
        // check permission in parent tags
        $tagPermissions = [];
        $currentTag = $tag;
        while ($currentTag) {
            $tagPermissions[] = 'read documents in tag ' . $currentTag->id;
            $currentTag = $currentTag->parent; // Move to the parent tag.
        }
        if ($user->hasAnyPermission($tagPermissions)) {
                return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create tags.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->can('create tags')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can update the tag.
     *
     * @param \App\User $user
     * @param \App\Tag $tag
     * @return mixed
     */
    public function update(User $user, Tag $tag)
    {
        if ($user->can('update tags')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the tag.
     *
     * @param \App\User $user
     * @param \App\Tag $tag
     * @return mixed
     */
    public function delete(User $user, Tag $tag)
    {
        if ($user->can('delete tags')) {
            return true;
        } else {
            return false;
        }
    }

}
