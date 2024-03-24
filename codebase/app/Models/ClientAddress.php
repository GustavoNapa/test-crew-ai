<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'codIbge',
        'street',
        'number',
        'complement',
        'zipCode',
        'neighborhood',
        'city',
        'state',
        'country'
    ];
}
