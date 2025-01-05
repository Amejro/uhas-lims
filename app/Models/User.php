<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Mail\UserCreated;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        foreach ($this->role as $role) {
            foreach ($role->permissions as $singlepermission) {
                $permissionArray[] = $singlepermission->name;

            }

        }
        return collect($permissionArray)->unique()->contains($permission);

    }


    public function is_active()
    {
        return $this->is_active;
    }

    public function reset_default_password()
    {
        return $this->reset_default_password;
    }

    public function is_super_admin()
    {
        return $this->role()->where('code', 'super_admin')->exists();
    }

    public function is_admin()
    {
        return $this->role()->where('code', 'admin')->exists();
    }

    public static function booted()
    {
        $defaultPassword = Str::random(10);

        static::creating(function ($model) use ($defaultPassword) {

            if (!empty($model->role_id)) {
                $model->password = Hash::make($defaultPassword);
            }

        });

        static::created(function ($model) use ($defaultPassword) {


            Mail::to($model->email)->send(new UserCreated($defaultPassword, $user = $model));


            Notification::make()
                ->title('Account Created Successfully')
                ->success()
                ->body('An email has been sent to ' . $model->email . ' with the default password')
                ->persistent()
                ->send();

        });




    }

}
