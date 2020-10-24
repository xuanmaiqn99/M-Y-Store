<?php

namespace App\Listeners;

use Mail;
use App\Mail\SendEmail;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use App\Events\SendMailOrder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ListenerSendMailOrder implements ShouldQueue
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
    public function handle(SendMailOrder $event)
    {
        $email = $event->data['email'];
        Mail::to($email)->queue(new SendEmail($event->data));
    }
}
