<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotifiOrderSuccess implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $info;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($info)
    {
        $this->info = $info;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('notifi-order');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->info->id,
            'link' => url('/admin/' . $this->info->id . '/notification.html'),
            'title' => $this->info->data['message'],
            'date' => $this->info->created_at->diffForHumans()
        ];
    }
}
