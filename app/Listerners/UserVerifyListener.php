<?php

namespace App\Listerners;

use App\Events\UserVerifyEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use App\Mail\SendVerification;


class UserVerifyListener implements ShouldQueue
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
     * @param  UserVerifyEvent  $event
     * @return void
     */
    public function handle(UserVerifyEvent $event)
    {
        $email = $event->user->email;
        Mail::to($email)->send(new SendVerification($event->user));
    }
    public function failed(UserVerifyEvent $event, $exception)
    {
        dd($exception);
    }
}
