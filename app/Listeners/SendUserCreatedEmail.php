<?php

namespace App\Listeners;

use App\Mail\UserInfo;
use App\Events\UserCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendUserCreatedEmail
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
    public function handle(UserCreated $event): void
    {
        Mail::to($event->user->email)->send(new UserInfo([
            "name" => $event->user->name,
            "email" => $event->user->email,
            "password" => $event->password
        ]));
    }
}
