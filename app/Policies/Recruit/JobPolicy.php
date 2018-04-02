<?php

namespace PacketPrep\Policies\Recruit;

use PacketPrep\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use PacketPrep\Models\Recruit\Job;

class JobPolicy
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
     * Determine if the given post can be created by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function create(User $user)
    { 
        return $user->checkRole(['administrator','hr-manager','recruiter']);
    }


    /**
     * Determine if the given post can be created by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function edit(User $user,Job $job)
    { 
        if($user->checkRole(['administrator','hr-manager','recruiter'])){
            if($job->user_id == $user->id )
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
    public function update(User $user,Job $job)
    { 
        if($user->checkRole(['administrator','hr-manager','recruiter'])){
            if($job->user_id == $user->id )
                return true;
            else
                return false;
        }
        else
            return false;
    }


    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

}