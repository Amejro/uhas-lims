<?php

namespace App\Jobs;

use App\Models\Inventory;
use App\Models\Sample;
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

        if ($test->reagent_kit) {
            collect($test->reagent_kit)->map(function ($kit) {
                $inventory = Inventory::find($kit['reagent_kit']);
                $inventory->total_quantity -= (int) $kit['quantity'];
                if ($inventory->total_quantity < $inventory->restock_quantity) {
                    $inventory->status = 'out_of_stock';
                }
                $inventory->save();
            });
        }



    }
}
