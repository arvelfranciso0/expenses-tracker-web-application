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


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
