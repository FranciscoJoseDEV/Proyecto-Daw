<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Defaulter extends Model
{
    protected $table = 'defaulters';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'description',
        'amount',
        'inicial_date',
        'due_date',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
