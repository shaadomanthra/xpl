<?php

namespace PacketPrep\Policies\Dataentry;

use PacketPrep\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
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
        return $user->checkRole(['administrator','investor','patron','promoter','employee','data-manager','data-lead','feeder','proof-reader','renovator','validator']);
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
        return $user->checkRole(['administrator','data-manager','data-lead']);
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
        if($user->checkRole(['administrator','data-manager','data-lead'])){
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
        return $user->checkRole(['administrator','data-manager','data-lead']);
    }


    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}
