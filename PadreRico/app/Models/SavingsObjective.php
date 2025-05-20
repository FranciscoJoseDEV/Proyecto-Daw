<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingsObjective extends Model
{
    use HasFactory;

    protected $table = 'savings_objective';

    protected $fillable = [
        'objective_name',
        'goal_amount',
        'date_limit',
        'status',
        'user_id',
    ];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
