<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductionBatcheLine extends Model
{

    protected $fillable = [
        'quantity',
        'estimate_quantity',
        'product_variant_id',
        'production_batche_id',
    ];


    protected $casts = [
        'id' => 'integer',
        'product_variant_id' => 'integer',
        'production_batche_id' => 'integer',
    ];



    public function productionBatche(): BelongsTo
    {
        return $this->belongsTo(ProductionBatche::class);
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
