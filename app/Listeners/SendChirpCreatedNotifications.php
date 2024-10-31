<?php

namespace App\Listeners;

use App\Events\ChirpCreated;
use App\Models\User;
use App\Notifications\NewChirp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendChirpCreatedNotifications
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        Log::debug("listen");
    }

    /**
     * Handle the event.
     */
    public function handle(ChirpCreated $event): void
    {
        Log::debug("ini masuk handle btw", ["e" => $event]);
        foreach (User::whereNot('id', $event->chirp->user_id)->cursor() as $user) {
            Log::debug("send notif", [ 'u' => $user]);
            $user->notify(new NewChirp($event->chirp));
        }
    }
}
