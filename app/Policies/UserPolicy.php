<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MenuItem;
use App\Models\Menu;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        // Admin can bypass all policies
        if ($user->hasRole('admin')) {
            return true;
        }
    }
    public function manageUsers(User $user)
    {
        return $user->hasRole('admin');
    }
        public function manageSubscribers(User $user)
    {
        return $user->hasRole('admin');
    }
        public function manageOperators(User $user)
    {
        return $user->hasRole('admin');
    }
    public function manageResturant(User $user)
    {
        return $user->hasAnyRole(['operator', 'restaurant_owner']);
    }
    public function viewDashboard(User $user)
    {
        return $user->hasAnyRole(['operator', 'restaurant_owner']);
    }

    public function viewMenuItems(User $user)
    {
        return $user->hasAnyRole(['operator', 'restaurant_owner']);
    }

    public function editMenuItem(User $user, MenuItem $menuItem)
    {
        return $user->hasAnyRole(['operator', 'restaurant_owner']) || $user->restaurants->contains($menuItem->menu->restaurant_id);
    }

    public function updateMenuItem(User $user, MenuItem $menuItem)
    {
        return $user->hasAnyRole(['operator', 'restaurant_owner']) || $user->restaurants->contains($menuItem->menu->restaurant_id);
    }

    public function viewMenus(User $user)
    {
        return $user->hasAnyRole(['operator', 'restaurant_owner']);
    }

    public function editMenu(User $user, Menu $menu)
    {
        return $user->hasAnyRole(['operator', 'restaurant_owner']) || $user->restaurants->contains($menu->restaurant_id);
    }

    public function updateMenu(User $user, Menu $menu)
    {
        return $user->hasAnyRole(['operator', 'restaurant_owner']) || $user->restaurants->contains($menu->restaurant_id);
    }

    public function createMenuItem(User $user)
    {
        return $user->hasRole('operator','restaurant_owner');
    }

    public function deleteMenuItem(User $user, MenuItem $menuItem)
    {
        return $user->hasRole('restaurant_owner');
    }

    public function createMenu(User $user)
    {
        return $user->hasRole('operator','restaurant_owner');
    }

    public function deleteMenu(User $user, Menu $menu)
    {
        return $user->hasRole('restaurant_owner');
    }
}
