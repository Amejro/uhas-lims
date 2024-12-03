<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SampleTest extends Pivot
{
    public static function booted(): void
    {
        static::creating(function ($record) {
            $record->status = "pending";
            $record->test_result = null;
        });
    }
}
