<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Test extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'reagent_kit',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'reagent_kit' => 'array',
    ];

    public function templates(): HasMany
    {
        return $this->hasMany(Template::class);
    }

    public function samples(): BelongsToMany
    {
        return $this->belongsToMany(Sample::class);
    }

    // public function inventories(): BelongsToMany
    // {
    //     return $this->belongsToMany(Inventory::class);
    // }

    public function inventories(): BelongsToMany
    {
        return $this->belongsToMany(Test::class)
            ->using(Inventory::class);
        // ->withPivot(['status', 'test_result']);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_id = auth()->id();

        });

        // static::updating(function ($model) {
        //     $model->price *= 100;
        // });



    }
}
