<?php

namespace App\Models;

use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PaymentRecord extends Model
{
    use HasFactory;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'payment_method',
        'transaction_id',
        'note',
        'payment_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'payment_id' => 'integer',
        'user_id' => 'integer',
    ];





    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            // ->logOnly(['user_id', 'amount']);
            ->logOnlyDirty();
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_id = auth()->id();
            // dd($model);

        });

        static::created(function ($model) {
            $payment = Payment::find($model->payment_id);
            $payment->amount_paid += $model->amount;
            $payment->balance_due = $payment->total_amount - $payment->amount_paid;
            $payment->status = ($payment->balance_due == 0) ? 'paid' : 'part payment';
            $payment->save();

        });
    }
}
