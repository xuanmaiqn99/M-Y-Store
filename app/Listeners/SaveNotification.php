<?php

namespace App\Listeners;

use App\Events\StatusLiked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notification;

class SaveNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(StatusLiked $event)
    {
        // Notification::create($event->info);
    }
}
