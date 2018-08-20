<?php

namespace PacketPrep\Policies\Product;

use PacketPrep\User;
use PacketPrep\Models\Product\Client;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
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
        return $user->checkRole(['administrator','investor','patron','promoter','employee','marketing-manager','marketing-executive','manager']);
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
        return $user->checkRole(['administrator','manager','marketing-manager','marketing-executive']);
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
        if($user->checkRole(['administrator','manager','marketing-manager','marketing-executive'])){
            if($client->user_id_creator==$user->id )
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
        return $user->checkRole(['administrator','manager','marketing-manager','marketing-executive']);
    }


    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}
