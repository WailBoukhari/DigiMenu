<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Menu;
use Illuminate\Auth\Access\HandlesAuthorization;

class RestaurantOwnerPolicy
{
    use HandlesAuthorization;

    public function viewMenu(User $user)
    {
        // Restaurant owners can view the menu
        return $user->hasRole('restaurant_owner');
    }

    public function createMenu(User $user)
    {
        // Restaurant owners can create new menu items
        return $user->hasRole('restaurant_owner');
    }

    public function updateMenu(User $user, Menu $menu)
    {
        // Restaurant owners can update their own menu items
        return $user->hasRole('restaurant_owner') && $menu->restaurant_id == $user->id;
    }

    public function deleteMenu(User $user, Menu $menu)
    {
        // Restaurant owners can delete their own menu items
        return $user->hasRole('restaurant_owner') && $menu->restaurant_id == $user->id;
    }

    // Add more authorization methods as needed
}