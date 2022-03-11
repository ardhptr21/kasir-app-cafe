<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['member_code', 'name', 'phone', 'address', 'point'];

    public function getRouteKeyName()
    {
        return 'member_code';
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['member'] ?? false, function ($query, $member) {
            return $query
                ->where('member_code', $member)
                ->orWhere('name', 'like', "%{$member}%");
        });
    }
}
