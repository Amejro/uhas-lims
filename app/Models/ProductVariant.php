<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{




    protected $fillable = [
        'name',
        'price',
        'size',
        'quantity',
        'status',
        'user_id',
        'product_id',

    ];

    protected $casts = [
        'id' => 'integer',
        'price' => 'integer',
        'size' => 'integer',
        'quantity' => 'integer',
        'user_id' => 'integer',
        'product_id' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_id = auth()->id();
            $model->status = 'available';

        });
    }
}
