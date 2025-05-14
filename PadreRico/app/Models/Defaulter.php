<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Defaulter extends Model
{
    use HasFactory;

    protected $fillable = [
        'debtor_user_id',
        'beneficiary_user_id',
        'description',
        'amount',
        'inicial_date',
        'due_date',
    ];

    /**
     * Obtener el usuario que es deudor.
     */
    public function debtor()
    {
        return $this->belongsTo(User::class, 'debtor_user_id');
    }

    /**
     * Obtener el usuario que es beneficiario.
     */
    public function beneficiary()
    {
        return $this->belongsTo(User::class, 'beneficiary_user_id');
    }
}
