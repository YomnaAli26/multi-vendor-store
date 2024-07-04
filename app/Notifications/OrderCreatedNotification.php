<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    protected $order;
    protected $address;


    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->address = $this->order->billingAddress;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database','broadcast'];
//        $channels = ['database'];
//        if ($notifiable->notification_preferences['order_created']['sms'] ?? false)
//        {
//            $channels[] = 'vonage';
//        }
//        if ($notifiable->notification_preferences['order_created']['mail'] ?? false)
//        {
//            $channels[] = 'mail';
//
//        }
//        if ($notifiable->notification_preferences['order_created']['sms'] ?? false)
//        {
//            $channels[] = 'broadcast';
//
//        }
//        return $channels;

    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("New Order #{$this->order->number}")
            ->greeting("Hi {$notifiable->name},")
            ->line("A new order #{$this->order->number} created by {$this->address->name}
                    from {$this->address->country_name}.")
            ->action('View Order', url('/dashboard'))
            ->line('Thank you for using our application!');
    }


    public function ToDatabase(object $notifiable)
    {
        return[
            'title'=>  "A new order #{$this->order->number} created.",
            'icon'=>'far fa-file',
            'url'=>url('/dashboard'),
            'order_id'=>$this->order->id
        ];
    }

    public function ToBroadcast(object $notifiable)
    {
        return new BroadcastMessage(
            [
                'title'=>  "A new order #{$this->order->number} created by {$this->address->name} from {$this->address->country_name}.",
                'icon'=>'far fa-file',
                'url'=>url('/dashboard'),
                'order_id'=>$this->order->id
            ]
        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
