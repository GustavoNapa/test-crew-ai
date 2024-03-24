<?php
namespace App\Gateways;

use App\Http\Helpers\ResponseHTTPHelper;
use App\Http\Helpers\ResponseHTTPService;
use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class SuitPayGateway implements PaymentGatewayInterface
{
    public function transfer($amount) {
        // Transfer amount
    }

    public function balance($accountId) {
        // Get balance
    }

    public function getPixQrCodeStatus(string $transactionId){
        // Get Status for a QR Code
    }

    public function generateQrCode(array $transactionData, array $clientData, $clientAddress = null, $products = null, $split = null) {
        $response = $this->request('/v1/gateway/request-qrcode', 'POST', $this->mountGenerateQrCodeData($transactionData, $clientData, $clientAddress, $products, $split));

        return response()->json($response, $response->status());
    }

    private function sendQrCode($qrCode) {
        // Send QR Code
    }   

    private function getQrCodeStatus($transactionId) {
        // Get QR Code Status
    }

    private function mountGenerateQrCodeData($transactionData, $clientData, $clientAddress, $products, $split) {
        if($clientData) {
            $transactionData['client'] = $clientData;
        }

        if($clientAddress) {
            $transactionData['client']['address'] = $clientAddress;
        }
        
        if($products) {
            $transactionData['products'] = $products;
        }
        
        if($split) {
            $transactionData['split'] = $split;
        }

        $transactionData['callbackUrl'] = env('APP_URL') . '/api/v1/webhook/transactions';

        return $transactionData;
    }

    private function request($endpoint, $method, $data): JsonResponse {
        if(env('APP_ENV') == 'production') {
            $url = env('SUITPAY_PRODUCTION_URL');
            $clientId = env('SUITPAY_PRODUCTION_CLIENT_ID');
            $clientSecret = env('SUITPAY_PRODUCTION_CLIENT_SECRET');
        } else {
            $url = env('SUITPAY_SANDBOX_URL_TEST');
            $clientId = env('SUITPAY_SANDBOX_CLIENT_ID_TEST');
            $clientSecret = env('SUITPAY_SANDBOX_CLIENT_SECRET_TEST');
        }

        try {
            if($method == 'GET') {
                $return = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'ci' => $clientId,
                    'cs' => $clientSecret
                ])
                ->get($url . $endpoint, $data);
            } else {
                $return = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'ci' => $clientId,
                    'cs' => $clientSecret
                ])
                ->post($url . $endpoint, $data);
            }
            
            if($return->body() === 'Unauthorized') {
                return ResponseHTTPHelper::error(401, "Não autorizado", $return->body());
            }
            
            // if($return->body()->success == false || $return->body()->message == 'error'){
            //     return ResponseHTTPHelper::error($return->status(), "Erro", $return->body());
            // }

            // dd($return->status(), $return->body());

            if($return->status() !== 200) {
                return ResponseHTTPHelper::error($return->status(), "Erro", $return->body());
            }
            
            return ResponseHTTPHelper::success($return->status(), "Sucesso", $return->body());
        } catch (\Exception $e) {
            $return = $e->getMessage();
            // dd($e);
            return ResponseHTTPHelper::error(500, "Erro", $return);
        }
    }

    public function withdrawPix($key, $keyType, $amount, $requestNumber=null, $callbackUrl=null, $documentValidation=null) {
        $response = $this->request('/v1/gateway/pix-payment', 'POST', $this->mountWithdrawPixData($key, $keyType, $amount, $requestNumber, $callbackUrl, $documentValidation));

        return response()->json($response, $response->status());
    }

    private function mountWithdrawPixData($key, $keyType, $amount, $requestNumber=null,$documentValidation=null) {
        $data = [
            'key' => $key,
            'typeKey' => $keyType,
            'value' => $amount
        ];

        if($requestNumber) {
            $data['requestNumber'] = $requestNumber;
        }

        $data['callbackUrl'] = env('APP_URL') . '/api/v1/webhook/withdraw/pix';

        if($documentValidation) {
            $data['documentValidation'] = $documentValidation;
        }

        return $data;
    }
}