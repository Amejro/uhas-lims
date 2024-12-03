<?php

namespace App\Models;

use App\Models\SampleTest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sample extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'quantity',
        'collection_date',
        'active_ingredient',
        'delivered_by',
        'deliverer_contact',
        'indication',
        'status',
        'dosage',
        'date_of_manufacture',
        'expiry_date',
        'batch_number',
        'serial_code',
        'storage_location_id',
        'dosage_form_id',
        'user_id',
        'producer_id',
        'total_cost',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'collection_date' => 'timestamp',
        'date_of_manufacture' => 'timestamp',
        'expiry_date' => 'timestamp',
        'storage_location_id' => 'integer',
        'dosage_form_id' => 'integer',
        'user_id' => 'integer',
        'producer_id' => 'integer',
        'active_ingredient' => 'array',
        'indication' => 'array',
    ];

    public function storageLocation(): BelongsTo
    {
        return $this->belongsTo(StorageLocation::class);
    }

    public function dosageForm(): BelongsTo
    {
        return $this->belongsTo(DosageForm::class);
    }

    public function producer(): BelongsTo
    {
        return $this->belongsTo(Producer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // public function tests(): BelongsToMany
    // {
    //     return $this->belongsToMany(Test::class);
    // }

    public function tests(): BelongsToMany
    {
        return $this->belongsToMany(Test::class)
            ->using(SampleTest::class)
            ->withPivot(['status', 'test_result']);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_id = auth()->id();
        });

        // static::created(function ($model) {


        //     $currentSample = Sample::find($model->id)->first();
        //     dd($currentSample);
        // });


    }
}
