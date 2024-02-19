<?php

// OperatorPolicy.php
namespace App\Policies;

use App\Models\User;
use App\Models\Menu;
use Illuminate\Auth\Access\HandlesAuthorization;

class OperatorPolicy
{
    use HandlesAuthorization;

    public function manageMenu(User $user, Menu $menu)
    {
        // Operators can manage menu items assigned to their restaurant
        return $user->hasRole('operator') && $menu->restaurant_id == $user->restaurant_id;
    }

    // Add more authorization methods as needed
}

