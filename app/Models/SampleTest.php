<?php

namespace App\Models;

use App\Jobs\UpdateInventoryJob;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SampleTest extends Pivot
{
    public static function booted(): void
    {
        static::creating(function ($record) {
            $record->status = "pending";
            $record->test_result = null;
        });

        static::updating(function ($record) {

            if ($record->status = "completed" && $record->inventory_updated !== true) {
                UpdateInventoryJob::dispatch($record->id);

            }

        });

        // static::created(function ($record) {
        //     $sample = Sample::Find($record->sample_id);
        //     // dd($sample);
        //     $template = Template::where('test_id', $record->test_id)->where('dosage_form_id', $sample)->get();

        //     info($sample);

        // });


    }
}
