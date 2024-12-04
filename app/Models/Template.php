<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Template extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'content',
        'test_id',
        'dosage_form_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'content' => 'array',
        'test_id' => 'integer',
        'dosage_form_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function dosageForms(): HasMany
    {
        return $this->hasMany(DosageForm::class);
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function dosageForm(): BelongsTo
    {
        return $this->belongsTo(DosageForm::class);
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



    }
}
