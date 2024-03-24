<?php 
namespace App\Http\Services;

use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Http\JsonResponse;

class PaymentService
{
    protected $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function generateQrCode($transactionData, $clientData, $clientAddress, $products, $split): JsonResponse {
        return $this->paymentGateway->generateQrCode($transactionData, $clientData, $clientAddress, $products, $split);
    }

    public function withdrawPix($key, $keyType, $amount, $requestNumber=null,$documentValidation=null): JsonResponse {
        return $this->paymentGateway->withdrawPix($key, $keyType, $amount, $requestNumber, $documentValidation);
    }
}