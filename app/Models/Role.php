<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

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
    const SUPER_AMINISTRATOR = 'Super Administrator';
    const AMINISTRATOR = 'Administrator';
    const HOD = 'HOD';
    const EXAMINER = 'Examiner';
    const STUDENT = 'Student';

    const ROLES = [
        'Administrator' => 'Administrator',
        'HOD' => 'HOD',
        'Student' => 'Student',
        'Supervisor' => 'Supervisor',
    ];
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
