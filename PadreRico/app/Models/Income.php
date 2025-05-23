<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Income extends Model
{
    protected $table = 'income';

    protected $fillable = [
        'category',
        'amount',
        'date',
        'description',
        'user_id',
        'recurrent',
    ];

    protected $casts = [
        'date' => 'datetime',
        'amount' => 'float',
    ];

    public function user(): BelongsTo
    {
        
        return $this->belongsTo(User::class);
    }
}
