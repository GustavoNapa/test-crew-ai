<?php

namespace App\Interfaces;

interface PaymentGatewayInterface
{
    // public function pay($amount);
    // public function refund($transactionId, $amount);

    public function transfer($amount);
    // public function balance($accountId);
    public function generateQrCode(array $transactionData, array $clientData, $clientAddress = null, $products = null, $split = null);
    public function getPixQrCodeStatus(string $transactionId);
    public function withdrawPix($key, $keyType, $amount, $requestNumber=null,$documentValidation=null);
}