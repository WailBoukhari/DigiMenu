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

        $owner = $restaurant->owner;

        if ($owner) {
            $owner->notify(new MenuItemAddedNotification($menuItem));
        }

        $operators = $restaurant->operators;

        foreach ($operators as $operator) {
            if ($operator) {
                $operator->notify(new MenuItemAddedNotification($menuItem));
            }
        }
    }

}
