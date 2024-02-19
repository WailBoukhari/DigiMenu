<?php

// OperatorPolicy.php
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OperatorPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view the menu item.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewMenuItem(User $user)
    {
        return $user->hasRole('operator');
    }

    /**
     * Determine whether the user can create menu items.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewRestaurantInfo(User $user)
    {
        return $user->hasRole('operator');
    }

    /**
     * Determine whether the user can edit the menu item.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */

    public function createMenuItem(User $user)
    {
        return $user->hasRole('operator');
    }

    /**
     * Determine whether the user can edit the menu item.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function editMenuItem(User $user)
    {
        return $user->hasRole('operator');
    }

    /**
     * Determine whether the user can delete the menu item.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function deleteMenuItem(User $user)
    {
        return $user->hasRole('operator');
    }
}


