<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'nik',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function scopeFilter(Builder $query, array $filters)
    {

        $query->when($filters['user'] ?? false, function (Builder $query, string $user) {
            $query->where(function (Builder $query) use ($user) {
                $query
                    ->where('name', 'like', "%$user%")
                    ->orWhere('username', 'like', "%$user%")
                    ->orWhere('email', 'like', "%$user%");
            });
        });

        $query->when($filters['role'] ?? false, function (Builder $query, string $role) {
            $query->where('role', $role);
        });
    }

    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    public function isOwner()
    {
        return $this->role == 'owner';
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
