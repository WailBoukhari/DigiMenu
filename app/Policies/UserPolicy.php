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
        return $user->hasRole('restaurant_owner');
    }

    public function deleteMenuItem(User $user, MenuItem $menuItem)
    {
        // Allow deletion if the user has the 'restaurant_owner' role and owns the menu item
        return $user->hasRole('restaurant_owner') && $user->id === $menuItem->user_id;
    }
    public function createMenu(User $user)
    {
        return $user->hasRole('restaurant_owner');
    }

    public function deleteMenu(User $user, Menu $menu)
    {
        // Allow deletion if the user has the 'restaurant_owner' role and owns the menu
        return $user->hasRole('restaurant_owner') && $user->id === $menu->user_id;
    }
}
