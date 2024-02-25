<?php

namespace App\Listeners;

use App\Events\MenuItemDeleted;
use App\Notifications\MenuItemDeletedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMenuItemDeleted implements ShouldQueue
{
    public function handle(MenuItemDeleted $event)
    {
        $menuItem = $event->menuItem;
        $restaurant = $menuItem->menu->restaurant;
        $recipients = collect([$restaurant->owner])->merge($restaurant->operators);

        $recipients->each(function ($recipient) use ($menuItem) {
            $recipient->notify(new MenuItemDeletedNotification($menuItem));
        });
    }
}
