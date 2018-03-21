<?php

namespace PacketPrep\Policies;

use PacketPrep\User;
use PacketPrep\Models\Content\Doc;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocsPolicy
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
    public function view(User $user,Doc $doc)
    {

        if($user->checkRole(['administrator','editor','documenter']))
            return true;

        

        if($user && $doc->status==1)
            return true;
        elseif(!$user && $doc->privacy==0)
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
    public function create(User $user)
    { 
        return $user->checkRole(['administrator','editor','documenter']);
    }


    /**
     * Determine if the given post can be created by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function edit(User $user,Doc $doc)
    { 
        return $user->checkRole(['administrator','editor','documenter']);
    }

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function update(User $user,Doc $doc)
    { 
        return $user->checkRole(['administrator','editor','documenter']);
    }


    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}
