<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['name', 'slug'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'unique' => true,
            ]
        ];
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['category'] ?? false, function (Builder $query, $category) {
            return $query->where('name', 'like', "%{$category}%");
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
