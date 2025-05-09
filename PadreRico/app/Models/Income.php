<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Income extends Model
{

    protected $table = 'incomes';

    protected $fillable = [
        'id',
        'category',
        'amount',
        'date',
        'type',
        'user_id',
    ];
}
