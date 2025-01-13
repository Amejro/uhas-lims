<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
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
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];
    const SUPER_AMINISTRATOR = 1;
    const AMINISTRATOR = 2;
    const TECHNICIAN = 3;
    const ACCOUNTANT = 4;
    const RECEPTIONIST = 5;
    const STORE_KEEPER = 6;

    const ROLES = [
        'super_Administrator' => 'super_administrator',
        'Administrator' => 'administrator',
        'Technician' => 'technician',
        'Accountant' => 'accountant',
        'Receptionist' => 'receptionist',
        'Store_Keeper' => 'store_keeper',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
            ])
            ->logOnlyDirty()
            ->useLogName('Role')
            ->dontSubmitEmptyLogs();
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_id = auth()->id();
        });
    }
}
