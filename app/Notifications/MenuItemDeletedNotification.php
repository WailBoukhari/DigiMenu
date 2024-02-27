<?php

namespace App\Notifications;

use App\Models\MenuItem;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MenuItemDeletedNotification extends Notification
{
    use Queueable;

    protected $menuItem;

    public function __construct(MenuItem $menuItem)
    {
        $this->menuItem = $menuItem;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Menu Item Deleted')
            ->line('A menu item has been deleted:')
            ->line('Name: ' . $this->menuItem->name)
            ->line('Description: ' . $this->menuItem->description)
            ->line('Price: ' . $this->menuItem->price)
            ->line('Thank you for using our application!');
    }
}
