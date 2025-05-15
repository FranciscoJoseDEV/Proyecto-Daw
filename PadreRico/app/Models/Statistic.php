<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mockery\CountValidator\AtMost;

class Statistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'general_balance',
        'income_total',
        'outcome_total',
        'outcome_category',
        'most_spending_day',
        'most_spending_day_total',
        'expenses_alert',
        'M_or_W',
        'date',
        'user_id',
    ];

    /**
     * Relación con el usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
