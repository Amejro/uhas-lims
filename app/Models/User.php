<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_active',
        'reset_default_password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class)->withPivot('user_id', 'role_id');
    // }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function hasRole(string $role): bool
    {
        return $this->role()->where('name', $role)->exists();
    }
    public function hasPermission(string $permission): bool
    {
        // return $this->roles()->where('permissions', 'LIKE', "%{$permission}%")->exists();

        $permissionArray = [];
        foreach ($this->roles as $role) {
            foreach ($role->permissions as $singlepermission) {
                $permissionArray[] = $singlepermission->name;

            }

        }
        return collect($permissionArray)->unique()->contains($permission);

    }




    public static function booted()
    {
        $defaultPassword = Str::random(10);

        static::creating(function ($model) use ($defaultPassword) {

            // $model->password = Hash::make($defaultPassword);

        });

        static::created(function ($model) use ($defaultPassword) {

            // Notification::make()
            //     ->title('Account Created Default password: ' . $defaultPassword)
            //     ->success()
            //     ->body('This default password is visible only once. Please change your password after login.')

            //     ->persistent()
            //     ->send();

        });




    }

}
