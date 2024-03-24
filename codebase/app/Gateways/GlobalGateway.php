<?php
namespace App\Http\Services;

use App\Interfaces\PaymentGatewayInterface;

class SuitPayBank implements PaymentGatewayInterface
{
    public function transfer($amount) {
        // Transfer amount
    }

    public function balance($accountId) {
        // Get balance
    }

    public function getPixQrCodeCharge(array $transactionData, array $clientData, $clientAddress = null, $products = null, $split = null) {
        // Get Pix QR Code charge
    }

    public function getPixQrCodeStatus(string $transactionId){
        // Get Status for a QR Code
    }
}