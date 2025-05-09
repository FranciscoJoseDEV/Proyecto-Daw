<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
{

    protected $table = 'outcome';

    protected $fillable = [
        'id',
        'category',
        'amount',
        'date',
        'type',
        'user_id',
    ];

    protected $casts = [
        'date' => 'datetime'
    ];
}
