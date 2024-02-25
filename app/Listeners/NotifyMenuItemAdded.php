<?php

namespace App\Listeners;

use App\Events\MenuItemAdded;
use App\Notifications\MenuItemAddedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMenuItemAdded implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\MenuItemAdded  $event
     * @return void
     */
    public function handle(MenuItemAdded $event)
    {
        $menuItem = $event->menuItem;

        $restaurant = $menuItem->menu->restaurant;

        $recipients = collect([$restaurant->owner]);

        $recipients = $recipients->merge($restaurant->operators);

        $recipients->each(function ($recipient) use ($menuItem) {
            $recipient->notify(new MenuItemAddedNotification($menuItem));
        });
    }

}
