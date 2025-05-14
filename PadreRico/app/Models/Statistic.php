<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'genral_balance',
        'income_vs_outcome',
        'outcome_category',
        'most_spending_day',
        'active_suscriptions',
        'expenses_alert',
        'M_or_W',
        'serial',
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