<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function manageRestaurantOwners(User $user): bool
    {
        dd('Checking manageRestaurantOwners method');

        return $user->hasRole('admin');
    }


    public function manageOperators(User $user): bool
    {
        return $user->hasRole('admin');
    }


    public function manageSubscribers(User $user): bool
    {
        return $user->hasRole('admin');
    }
}
