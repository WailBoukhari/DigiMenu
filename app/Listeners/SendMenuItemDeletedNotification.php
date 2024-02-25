<?php

namespace App\Listeners;

use App\Events\MenuItemDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMenuItemDeletedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MenuItemDeleted $event): void
    {
        //
    }
}
