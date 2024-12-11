<?php

namespace App\Jobs;

use App\Models\Sample;
use App\Models\SampleTest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CopyTestTemplate implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(Sample $sample, )
    {
        $this->sample = $sample;
    }

    /**
     * Execute the job.
     */
    public function handle(Sample $sample): void
    {



    }
}
