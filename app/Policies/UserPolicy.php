<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function validate(User $currentUser,User $user){
        return $currentUser->id == $user->id;
    }
}
