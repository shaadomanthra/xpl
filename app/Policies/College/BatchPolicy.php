<?php

namespace PacketPrep\Policies\College;

use PacketPrep\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BatchPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
     public function view(User $user)
    {
        return true;
    }


    /**
     * Determine if the given post can be created by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function create(User $user)
    { 
        return $user->checkRole(['administrator','manager','marketing-manager','marketing-executive','tpo']);
    }


    /**
     * Determine if the given post can be created by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function edit(User $user)
    { 
        if($user->checkRole(['administrator','manager','tpo'])){
            return true;
        }
        else
            return false;
    }

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function update(User $user)
    { 
        return $user->checkRole(['administrator','manager','marketing-manager','marketing-executive','tpo']);
    }


    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}
