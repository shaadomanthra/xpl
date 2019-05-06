<?php

namespace PacketPrep\Policies;

use PacketPrep\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function view(User $user)
    {
        return true;
    }


    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function update(User $user, User $u)
    { 
        if($user->id === $u->id)
            return true;
        else
            false;
    }

     /**
     * Determine if the given post can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function manage(User $user, User $u)
    { 
        return $user->checkRole(['administrator','user-manager']);
    }

    

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}
