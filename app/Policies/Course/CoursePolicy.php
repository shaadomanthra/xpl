<?php

namespace PacketPrep\Policies\Course;

use PacketPrep\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use PacketPrep\Models\Course\Course;

class CoursePolicy
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
    public function view(User $user, Course $course)
    {
        if($user->checkRole(['administrator','investor','patron','promoter','employee','data-manager','data-lead','feeder','proof-reader','renovator','client-owner','client-manager','manager']))
         {
            return true;
         }else{
            foreach($course->users as $u){
            if($u->id == $user->id)
                return true;
            }
         }

        return false;
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
    public function edit(User $user,Course $Course)
    { 
        if($user->checkRole(['administrator','data-manager'])){
            if($Course->user_id_data_manager==$user->id )
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
