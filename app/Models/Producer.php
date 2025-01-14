<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'gps_address',
        'phone',
        'email',
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
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'address',
                'gps_address',
                'phone',
                'email',
                'user_id',
            ])
            ->logOnlyDirty()
            ->useLogName('Producer')
            ->dontSubmitEmptyLogs();
    }

    public function samples(): HasMany
    {
        return $this->hasMany(Sample::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getForm()
    {
        return [
            TextInput::make('name')
                ->required(),
            TextInput::make('address')
                ->required(),
            TextInput::make('gps_address'),
            TextInput::make('phone')
                ->tel()
                ->required(),
            TextInput::make('email')
                ->email(),
        ];
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_id = auth()->id();


        });



    }
}
