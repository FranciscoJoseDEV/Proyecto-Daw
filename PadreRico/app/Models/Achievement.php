<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{       


    protected $table = 'achievements';

    protected $fillable = ['name', 'description', 'points', 'condition'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
