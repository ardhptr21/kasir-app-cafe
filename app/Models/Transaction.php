<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'total_price',
        'quantity',
        'period',
        'transaction_code'
    ];

    public function scopeFilter(Builder $query, array $filters)
    {
        if ($filters['search'] == 'day') {
            $query->when($filters['date'], function ($query, $date) {
                return $query->whereDate('created_at', $date);
            });
        }

        if ($filters['search'] == 'month') {
            $query->when($filters['date'], function ($query, $date) {
                return $query->where('period', $date);
            });
        }
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
