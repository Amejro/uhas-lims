<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    use LogsActivity;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'total_amount',
        'amount_paid',
        'serial_code',
        'balance_due',
        'status',
        'sample_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'sample_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'total_amount',
                'amount_paid',
                'serial_code',
                'balance_due',
                'status',
                'sample_id',
                'user_id',
            ])
            ->logOnlyDirty()
            ->useLogName('payment')
            ->dontSubmitEmptyLogs();
    }
    public function sample(): BelongsTo
    {
        return $this->belongsTo(Sample::class);
    }

    public function paymentRecords(): HasMany
    {
        return $this->hasMany(PaymentRecord::class);
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
