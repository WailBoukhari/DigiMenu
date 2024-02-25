<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\SubscriptionExpiredOwnerNotification;
use App\Notifications\SubscriptionExpiredOperatorNotification;
use Illuminate\Console\Command;

class DisableUserBaseOnSubTimeExpired extends Command
{
    protected $signature = 'disable:user_base_on_sub_time_expired';
    protected $description = 'Send notifications and disable users whose subscription time has expired';

    public function handle()
    {
        $expiredUsers = User::where('subscription_expires_at', '<=', now())->get();

        foreach ($expiredUsers as $user) {
            $owner = $user->ownedRestaurants->first()->owner;
            if ($owner) {
                $owner->notify(new SubscriptionExpiredOwnerNotification());
            }

            $operator = $user->restaurants->first()->operators->first();
            if ($operator) {
                $operator->notify(new SubscriptionExpiredOperatorNotification());
            }

            // Disable the user or perform any other action
            // For example: $user->delete();

            // Delete associated menus and menu items
            $user->menus->each(function ($menu) {
                $menu->menuItems()->delete();
                $menu->delete();
            });
        }

        $this->info('Expired users notified and disabled successfully.');
    }
}
