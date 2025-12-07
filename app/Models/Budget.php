<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount_limit',
        'month',
        'year',
    ];

    protected static function booted()
    {
        static::creating(function ($expense) {
            if (! isset($expense->user_id)) {
                $expense->user_id = auth()->id();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
