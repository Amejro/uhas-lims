<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductionBatche extends Model
{

    protected $fillable = [
        'batch_code',
        'quantity',
        'status',
        'variants',
        'product_id',
        'user_id',

    ];


    protected $casts = [
        'id' => 'integer',
        'variants' => 'array',
        'product_id' => 'integer',

        'user_id' => 'integer',
    ];


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function productionBatchLines(): HasMany
    {
        return $this->hasMany(ProductionBatcheLine::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {

            // dd($model);

            $model->batch_code = 'PB' . time();
            $model->user_id = auth()->id();
            $model->status = 'pending';
            ;
        });
    }
}
