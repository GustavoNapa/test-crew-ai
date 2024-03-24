<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_transaction',
        'client_id',
        'client_address_id',
        'product_id',
        'type',
        'key',
        'key_type',
        'user_id',
        'status',
        'requestNumber',
        'dueDate',
        'expiration_date',
        'payment_date',
        'amount',
        'shippingAmount',
        'discountAmount',
        'usernameCheckout',
        'callbackUrl',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function clientAddress()
    {
        return $this->belongsTo(ClientAddress::class);
    }   

    public function product()
    {
        return $this->belongsTo(Product::class);
    }       

    public function user()
    {
        return $this->belongsTo(User::class);
    }   
}
