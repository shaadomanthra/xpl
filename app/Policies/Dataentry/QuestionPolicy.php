<?php

namespace PacketPrep\Policies\Dataentry;

use PacketPrep\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use PacketPrep\Models\Dataentry\Question;
use PacketPrep\Models\Dataentry\Project;

class QuestionPolicy
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
        return $user->checkRole(['administrator','investor','patron','promoter','employee','data-manager','data-lead','feeder','proof-reader','renovator','validator','hr-manager']);
    }


    /**
     * Determine if the given post can be created by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function create(User $user,Question $question)
    { 
        $project = (new Project())->where('id',$question->project_id)->first();
        if($user->checkRole(['administrator','data-manager','data-lead','feeder'])){
            if($user->id == $project->user_id_data_manager || $user->id == $project->user_id_data_lead || $user->id == $project->user_id_feeder)
                return true;
            else
                return false;
        }elseif($user->checkRole(['hr-manager']))
            return true;
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
    public function publish(User $user,Question $question)
    { 
        $project = (new Project())->where('id',$question->project_id)->first();
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
    public function update(User $user,Question $question)
    { 
        $project = (new Project())->where('id',$question->project_id)->first();
        
        if($project->slug=='default'){
            if($user->checkRole(['administrator'])){
                return true;
            }
            if($user->id == $question->user_id)
                return true;
        }else{
            if($user->checkRole(['administrator','data-manager','data-lead','feeder'])){
            if($user->id == $project->user_id_data_manager || $user->id == $project->user_id_data_lead || $user->id == $project->user_id_feeder)
                return true;
            else
                return false;
        }
        else
            return false;
        }
       
    }


    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}
