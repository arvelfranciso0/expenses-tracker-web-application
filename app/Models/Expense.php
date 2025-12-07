<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'category_id',
        'expenses_date',
        'description',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeYearlyExpenses(Builder $query)
    {
        return $query->whereYear('created_at', now()->year);
    }

    public function scopeMonthlyExpenses(Builder $query)
    {
        return $query->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month);
    }
}
