<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;
    public function viewManageUsers(User $user)
    {
        return $user->hasRole('admin');
    }

    public function viewManageOperators(User $user)
    {
        return $user->hasRole('admin');
    }

    public function viewManageSubscribers(User $user)
    {
        return $user->hasRole('admin');
    }
    public function createUser(User $admin)
    {
        return $admin->hasRole('admin');
    }

    public function editUser(User $admin)
    {
        return $admin->hasRole('admin');
    }

    public function deleteUser(User $admin)
    {
        return $admin->hasRole('admin');
    }

    public function createOperator(User $admin)
    {
        return $admin->hasRole('admin');
    }

    public function editOperator(User $admin)
    {
        return $admin->hasRole('admin');
    }

    public function deleteOperator(User $admin)
    {
        return $admin->hasRole('admin');
    }

    public function assignRoles(User $admin)
    {
        return $admin->hasRole('admin');
    }

    public function receiveNotifications(User $admin)
    {
        return $admin->hasRole('admin');
    }
}

