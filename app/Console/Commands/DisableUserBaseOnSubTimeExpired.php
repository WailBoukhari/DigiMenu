<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DisableUserBaseOnSubTimeExpired extends Command
{
    protected $signature = 'disable:User_base_on_sub_time_expired';
    protected $description = 'Delete expired users along with their menus and menu items';

    public function handle()
    {
        $expiredUsers = User::where('subscription_expires_at', '<=', now())->get();

        foreach ($expiredUsers as $user) {
            $user->menus->each(function ($menu) {
                $menu->menuItems()->delete(); 
                $menu->delete(); 
            });
        }
        $this->info('Expired users and associated data deleted successfully.');
    }
}
