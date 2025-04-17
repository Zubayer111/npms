<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendUserUpdatedNotification
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
    public function handle(UserUpdated $event): void
    {
        //Log::info("User [{$event->user->name}] was updated by {$event->updatedBy->name}");
    }
}
