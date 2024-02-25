<?php

namespace App\Notifications;

use App\Models\MenuItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MenuItemAddedNotification extends Notification
{
    use Queueable;

    protected $menuItem;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(MenuItem $menuItem)
    {
        $this->menuItem = $menuItem;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Menu Item Added')
            ->line('A new menu item has been added.')
            ->line('Name: ' . $this->menuItem->name)
            ->line('Description: ' . $this->menuItem->description)
            ->line('Price: ' . $this->menuItem->price)
            ->line('Thank you for using our application!');
    }
}
