<?php

namespace PacketPrep\Policies;

use PacketPrep\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use PacketPrep\Models\Social\Social;

class SocialPolicy
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
        return $user->checkRole(['administrator','employee','editor','blog-moderator','blog-writer','social-media-moderator','social-media-writer']);
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
        return $user->checkRole(['administrator','editor','blog-moderator','blog-writer','social-media-moderator','social-media-writer']);
    }


    /**
     * Determine if the given post can be created by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function edit(User $user,Social $social)
    { 
        if($user->checkRole(['administrator','editor','blog-moderator','blog-writer','social-media-moderator','social-media-writer'])){
            if($blog->user_id==$user->id )
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
        return $user->checkRole(['administrator','manager','employee']);
    }


    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

}
