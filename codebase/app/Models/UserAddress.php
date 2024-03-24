<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'isPrimary',
        'postal_code',
        'street',
        'number',
        'neighborhood',
        'complement',
        'city',
        'state',
        'country',
        'additional_notes',
    ];
}
