<?php

namespace PacketPrep\Policies\Exam;

use PacketPrep\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use PacketPrep\Models\Exam\Exam;

class ExamPolicy
{
    use HandlesAuthorization;

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
        return $user->checkRole(['administrator','investor','patron','promoter','employee','data-manager','data-lead','feeder','proof-reader','renovator','validator','hr-manger']);
    }


    /**
     * Determine if the given post can be created by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function edit(User $user,Exam $exam)
    { 
        if($user->checkRole(['administrator','data-manager','hr-manager'])){
            if($exam->user_id==$user->id )
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
    public function update(User $user,Exam $exam)
    { 
        if($user->checkRole(['administrator','data-manager','hr-manager'])){
            if($exam->user_id==$user->id )
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
