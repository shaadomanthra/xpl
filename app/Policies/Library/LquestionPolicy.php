<?php

namespace PacketPrep\Policies\Library;

use PacketPrep\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use PacketPrep\Models\Library\Lquestion;
use PacketPrep\Models\Library\Repository;

class LquestionPolicy
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
    public function create(User $user,Lquestion $question)
    { 
        $project = (new Repository())->where('id',$question->project_id)->first();
        if($user->checkRole(['administrator','data-manager','data-lead','feeder'])){
            if($user->id == $project->user_id_data_manager || $user->id == $project->user_id_data_lead || $user->id == $project->user_id_feeder)
                return true;
            else
                return false;
        }
        else
            return false;
    }


    /**
     * Determine if the given post can be created by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function publish(User $user,Lquestion $question)
    { 
        $project = (new Repository())->where('id',$question->project_id)->first();
        if($user->checkRole(['administrator','data-manager','data-lead','proof-reader'])){
            if($user->id == $project->user_id_data_manager || $user->id == $project->user_id_data_lead || $user->id == $project->user_id_proof_reader)
                if($question->status==1)
                    return true;
                else
                    return false;
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
    public function update(User $user,Lquestion $question)
    { 
        $project = (new Repository())->where('id',$question->project_id)->first();
        
         if($user->checkRole(['administrator','data-manager','data-lead','feeder'])){
            if($user->id == $project->user_id_data_manager || $user->id == $project->user_id_data_lead || $user->id == $project->user_id_feeder)
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
