<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Budget extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'amount_limit',
        'source',
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

    public function scopeCurrentUser(Builder $query): void
    {
        $query->where('user_id', auth()->id());
    }

    public function activate()
    {

        DB::transaction(function () {

            Budget::where('user_id', $this->user_id)
                ->where('id', '!=', $this->id)
                ->update(['is_active' => false]);

            $this->is_active = true;
            $this->save();
        });
    }
}
