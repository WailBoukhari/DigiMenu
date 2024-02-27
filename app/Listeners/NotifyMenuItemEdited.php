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

        $owner = $restaurant->owner;

        if ($owner) {
            $owner->notify(new MenuItemEditedNotification($menuItem));
        }

        $operators = $restaurant->operators;

        foreach ($operators as $operator) {
            if ($operator) {
                $operator->notify(new MenuItemEditedNotification($menuItem));
            }
        }
    }
}
