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

        $owner = $restaurant->owner;

        if ($owner) {
            $owner->notify(new MenuItemDeletedNotification($menuItem));
        }

        $operators = $restaurant->operators;

        foreach ($operators as $operator) {
            if ($operator) {
                $operator->notify(new MenuItemDeletedNotification($menuItem));
            }
        }
    }
}
