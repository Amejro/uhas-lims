<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Inventory extends Model
{
    use HasFactory;
    use LogsActivity;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'unit',
        'total_quantity',
        'restock_quantity',
        'reorder_level',
        'expiry_date',
        'status',
        'item_variant',
        'storage_location_id',
        'user_id',

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'expiry_date' => 'timestamp',
        'item_variant' => 'array',
        'storage_location_id' => 'integer',
        'user_id' => 'integer',
        'total_quantity' => 'integer',
        'restock_quantity' => 'integer',
        'reorder_level' => 'integer',
    ];


    protected $variants;
    protected $totalQuantity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'description',
                'unit',
                'total_quantity',
                'restock_quantity',
                'reorder_level',
                'expiry_date',
                'status',
                'item_variant',
                'storage_location_id',
                'user_id',
            ])
            ->logOnlyDirty()
            ->useLogName('Inventory')
            ->dontSubmitEmptyLogs();
    }

    public function storageLocation(): BelongsTo
    {
        return $this->belongsTo(StorageLocation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tests(): BelongsToMany
    {
        return $this->belongsToMany(Test::class);
    }

    public function stockHistories(): HasMany
    {
        return $this->hasMany(StockHistory::class);
    }



    protected static function booted()
    {
        static::creating(function ($model) use (&$variants, &$totalQuantity) {



            $variants = $model->item_variant;
            $totalQuantity = $model->total_quantity;

            $model->user_id = auth()->id();
            $model->status = 'available';
            $model->total_quantity *= 1000;
            $model->reorder_level *= 1000;
            $model->item_variant = null;
            $model->restock_quantity = null;
        });



        static::created(function ($model) use (&$variants, &$totalQuantity) {


            $history = new StockHistory();

            $history->create([
                'inventory_id' => $model->id,
                'item_variant' => $variants,
                'action' => $model->total_quantity > 0 ? 'addition' : 'deduction',
                'total_quantity' => $totalQuantity * 1000,
                'user_id' => auth()->id(),
            ]);


        });

        static::updating(function ($model) {

            if ($model->restock_quantity > 0) {
                $history = new StockHistory();

                $history->create([
                    'inventory_id' => $model->id,
                    'item_variant' => $model->item_variant,
                    'action' => $model->total_quantity > 0 ? 'addition' : 'deduction',
                    'total_quantity' => $model->restock_quantity * 1000,
                    'user_id' => auth()->id(),
                ]);

                $model->user_id = auth()->id();
                $model->total_quantity += $model->restock_quantity * 1000; // restock_quantity is the new quantity to be added to the total_quantity
                // $model->reorder_level = $model->reorder_level * 1000;

                $model->item_variant = null;
                $model->restock_quantity = null;
            }


            $model->reorder_level = $model->reorder_level * 1000;
        });


    }
}
