<?php
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view resources.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function ViewManageMenus(User $user)
    {
        return $user->roles->isEmpty();
    }
}