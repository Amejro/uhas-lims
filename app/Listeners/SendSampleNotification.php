<?php

namespace App\Listeners;

use App\Events\SampleProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSampleNotification
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
    public function handle(SampleProcessed $event): void
    {
        // dd($event->sample);
        info($event->sample);
    }
}
