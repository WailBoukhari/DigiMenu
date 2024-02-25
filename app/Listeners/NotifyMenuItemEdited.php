<?php

namespace App\Listeners;

use App\Events\MenuItemEdited;
use App\Notifications\MenuItemEditedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMenuItemEdited implements ShouldQueue
{
    public function handle(MenuItemEdited $event)
    {
        $menuItem = $event->menuItem;
        $restaurant = $menuItem->menu->restaurant;
        $recipients = collect([$restaurant->owner])->merge($restaurant->operators);

        $recipients->each(function ($recipient) use ($menuItem) {
            $recipient->notify(new MenuItemEditedNotification($menuItem));
        });
    }
}
