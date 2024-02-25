<?php

namespace App\Providers;

use App\Events\MenuItemAdded;
use App\Events\MenuItemDeleted;
use App\Events\MenuItemEdited;
use App\Listeners\NotifyMenuItemAdded;
use App\Listeners\NotifyMenuItemDeleted;
use App\Listeners\NotifyMenuItemEdited;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        MenuItemAdded::class => [
            NotifyMenuItemAdded::class,
        ],
        MenuItemEdited::class => [
            NotifyMenuItemEdited::class,
        ],
        MenuItemDeleted::class => [
            NotifyMenuItemDeleted::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
