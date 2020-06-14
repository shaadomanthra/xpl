<?php

namespace PacketPrep\Policies\Job;

use PacketPrep\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
     public function view(User $user)
    {
        return $user->checkRole(['administrator','investor','patron','promoter','employee','marketing-manager','marketing-executive','manager','hr-manager']);
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
        return $user->checkRole(['administrator','manager','marketing-manager','marketing-executive','hr-manager']);
    }


    /**
     * Determine if the given post can be created by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function edit(User $user,Post $post)
    { 
        if($user->checkRole(['administrator','manager'])){
            return true;
        }
        else{
            if($user->checkRole(['hr-manager']))
                if($post->user_id==$user->id)
                    return true;
            else    
            return false;
        }
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
        return $user->checkRole(['administrator','manager','marketing-manager','marketing-executive','hr-manager']);
    }


    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}
