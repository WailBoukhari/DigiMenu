<?php

namespace App\Events;

use App\Models\MenuItem;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MenuItemDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $menuItem;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MenuItem $menuItem)
    {
        $this->menuItem = $menuItem;
    }
}
