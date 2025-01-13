<?php

namespace App\Models;

use App\Jobs\UpdateInventoryJob;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
            ->logOnly([
                'amount',
                'payment_method',
                'transaction_id',
                'note'
            ])
            ->logOnlyDirty()
            ->useLogName('payment')
            ->dontSubmitEmptyLogs();
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
            $model->transaction_id = '';

            // dd($model);transaction_id

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
