<?php

namespace App\Jobs;

use App\Models\Test;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdateInventoryJob implements ShouldQueue
{
    use Queueable;

    /**
     * The ID of the test.
     *
     * @var string
     */

    /**
     * Create a new job instance.
     */
    public function __construct(public string $test_id)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $test = Test::find($this->test_id);
        dd($test);
    }
}
