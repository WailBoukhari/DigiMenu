<?php
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RestaurantOwnerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can manage menus.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function ViewManageMenus(User $user)
    {
        return $user->hasRole('restaurant_owner');
    }

    /**
     * Determine whether the user can view the restaurant information.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewRestaurantInfo(User $user)
    {
        return $user->hasRole('restaurant_owner');
    }

    /**
     * Determine whether the user can update the restaurant information.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function updateRestaurantInfo(User $user)
    {
        return $user->hasRole('restaurant_owner');
    }

    /**
     * Determine whether the user can add new items to the menu.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function addItemToMenu(User $user)
    {
        return $user->hasRole('restaurant_owner');
    }

    /**
     * Determine whether the user can edit items on the menu.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function editMenuItem(User $user)
    {
        return $user->hasRole('restaurant_owner');
    }

    /**
     * Determine whether the user can delete items from the menu.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function deleteMenuItem(User $user)
    {
        return $user->hasRole('restaurant_owner');
    }
}
