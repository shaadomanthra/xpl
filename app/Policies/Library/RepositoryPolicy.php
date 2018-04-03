<?php

namespace PacketPrep\Policies\Library;

use PacketPrep\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use PacketPrep\Models\Library\Repository;

class RepositoryPolicy
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
        return $user->checkRole(['administrator','data-manager','data-lead','feeder','proof-reader','renovator','validator','content-engineer']);
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
        return $user->checkRole(['administrator','data-manager']);
    }


    /**
     * Determine if the given post can be created by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function edit(User $user,Repository $repo)
    { 
        if($user->checkRole(['administrator','data-manager'])){
            if($repo->user_id_data_manager==$user->id )
                return true;
            else
                return false;
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
        return $user->checkRole(['administrator','data-manager']);
    }


    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}
