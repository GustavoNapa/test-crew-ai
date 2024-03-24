<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebhookTransactionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'transaction_id',
        'transaction_data',
        'status',
        'id_transaction',
        'payment_code',
        'payment_code_base64',
        'message',
        'response',
        'body'
    ];
}
