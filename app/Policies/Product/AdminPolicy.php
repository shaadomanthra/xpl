<?php

namespace PacketPrep\Policies\Product;

use PacketPrep\User;
use PacketPrep\Models\Product\Client;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the clients.
     *
     * @param  \PacketPrep\User  $user
     * @param  \PacketPrep\Clients  $clients
     * @return mixed
     */
    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function view(User $user)
    {
        if($user->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager','hr-manager']))
        {
                return true;
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
    public function create(User $user,Client $client)
    { 
       if($user->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager']))
        {
            if($client->getPackageName())
                return true;
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
    public function edit(User $user,Client $client)
    { 
        if($user->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager'])){
           if($client->getPackageName())
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
        return $user->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager']);
    }


    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}
