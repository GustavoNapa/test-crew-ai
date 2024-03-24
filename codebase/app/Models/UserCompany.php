<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cnpj',
        'company_name',
        'fantasy_name',
        'municipal_registration',
        'state_registration',
    ];
}
