<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PostPolicy
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

    public function update_post($user){
        if ($user->type == 'admin') {
            return Response::allow();
        }

        return Response::deny('Voce precisa ter premissao de admin');
    }
    
    public function delete_post($user, $post){
        if ($post->owner == $user->id) {
            return Response::allow();
        }

        return Response::deny('Somente o dono pode excluir um post');
    }

}
