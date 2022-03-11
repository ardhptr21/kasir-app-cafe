<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id', 'price'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['category'] ?? false, function (Builder $query, string $category) {
            $query->whereHas('category', function (Builder $query) use ($category) {
                $query->where('name', $category);
            });
        });

        $query->when($filters['service'] ?? false, function (Builder $query, string $service) {
            $query->where('name', 'like', "%{$service}%");
        });
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
