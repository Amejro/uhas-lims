<?php

namespace App\Providers;

use Event;
use App\RadioBlock;
use App\Events\SampleCreated;
use App\Events\SampleProcessed;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Support\ServiceProvider;
use App\Listeners\SendSampleNotification;
use App\Listeners\SendSampleCreatedNotification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //


    }
}
