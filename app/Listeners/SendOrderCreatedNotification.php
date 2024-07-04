<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderCreatedNotification
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
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;
        $user = User::where('store_id',$order->store_id)->first();
        if ($user)
        {
            $user->notify(new OrderCreatedNotification($order));
        }

//        $users = User::where('store_id',$order->store_id)->get();
//        Notification::send($users,new OrderCreatedNotification($order));

    }
}
