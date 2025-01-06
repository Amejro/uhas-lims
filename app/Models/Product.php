<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{

    protected $fillable = [
        'name',
        'description',
        'unit',
        'ingredient',
        'base_size',
        'storage_location_id',
        'user_id',

    ];


    protected $casts = [
        'id' => 'integer',
        'ingredient' => 'array',
        'storage_location_id' => 'integer',

        'user_id' => 'integer',
    ];

    public function productVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function productionBatch(): HasMany
    {
        return $this->hasMany(ProductionBatche::class);
    }


    public function storageLocation(): BelongsTo
    {
        return $this->belongsTo(StorageLocation::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_id = auth()->id();
            // $model->status = 'available';
            ;
        });
    }
}
