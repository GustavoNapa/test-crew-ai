<?php

namespace App\Http\Controllers\Api\Gateway;

use App\Factories\PaymentServiceFactory;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseHTTPHelper;
use App\Http\Requests\DynamicQrCodeRequest;
use App\Http\Services\Helpers;
use App\Http\Services\PaymentService;
use App\Http\Services\SuitPayBank;
use App\Models\Transaction;
use App\Models\Client;
use App\Models\ClientAddress;
use App\Models\Product;
use App\Models\User;
use App\Models\WebhookTransactionLog;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Log;

class DynamicQrCodeController extends Controller
{
    public function view()
    {
        $transactions = Transaction::all();
        return response()->json([
            'transactions' => $transactions,
            'message' => 'success'
        ], 200);
    }

    public function create(DynamicQrCodeRequest $request)
    {
        $validated = $request->validated();
        
        $clientId = null;
        $addressId = null;
        
        $transactionData = $validated;

        // dd($request); // Debug
        
        $clientData = $transactionData['client'];
        unset($clientData['address']);
        $clientAddress = $transactionData['client']['address'] ?? null;
        $products = $transactionData['products'] ?? null;
        $split = $transactionData['split'] ?? null;

        // dd($clientData, $clientAddress, $products, $split); // Debug
        
        $clientData['document'] = Helpers::numbersOnly($clientData['document']);

        if (Client::where('document', $clientData['document'])->exists()) {
            $client = Client::where('document', $clientData['document'])->first();

            $clientId = $client->id;

            $address = ClientAddress::where('client_id', $clientId)->first();
            
            // dd($client); // Debug
            if ($address) {
                $addressId = $address->id;
            } else {
                if (!empty($clientAddress)) {
                    try {
                        $clientAddress['client_id'] = $clientId;
                        $address = ClientAddress::where('client_id', $clientId)->update($clientAddress);
                        $addressId = $address->id;
                        // dd($address); // Debug
                    } catch (\Exception $e) {
                        // dd($e->getMessage()); // Debug
                        return response()->json(['message' => 'Erro ao criar endereço'], 500);
                    }
                }
            }
        } else {
            try {
                $client = Client::create($clientData);
                $clientId = $client->id;
                // dd($client); // Debug
            } catch (\Exception $e) {
                dd($e); // Debug
                return response()->json(['message' => 'Erro ao criar cliente'], 500);
            }
            
            if (!empty($clientAddress)) {
                try {
                    $clientAddress['client_id'] = $clientId;
                    $address = ClientAddress::create($clientAddress);
                    $addressId = $address->id;
                    // dd($address); // Debug
                } catch (\Exception $e) {
                    dd($e); // Debug
                    return response()->json(['message' => 'Erro ao criar endereço'], 500);
                }
            }
        }

        try {
            $transactionData['user_id'] = auth()->user()->id;
            $transactionData['client_id'] = $clientId;
            $transactionData['client_address_id'] = $addressId ?? null;

            // dd($transactionData); // Debug

            unset($transactionData['client']);
            unset($transactionData['address']);
            unset($transactionData['products']);
            unset($transactionData['split']);

            // dd($transactionData); // Debug
            
            $transaction = Transaction::create($transactionData);

            // dd($transaction); // Debug
        } catch (\Exception $e) {
            // dd($e); // Debug
            return response()->json(['message' => 'Erro ao criar transação'], 500);
        }

        if (!empty($products)) {
            try {
                // dd($products); // Debug
                
                foreach ($products as $key => $product) {
                    $product['transaction_id'] = $transaction->id;
                    $product['price'] = $product['value'];
                    unset($product['value']);
                    Product::create($product);
                }                
            } catch (\Exception $e) {
                // dd($e); // Debug
                return response()->json(['message' => 'Erro ao criar produto'], 500);
            }
        }

        unset($transactionData['client_id']);
        unset($transactionData['client_address_id']);
        unset($transactionData['product_id']);

        unset($clientAddress['client_id']);

        // dd($transactionData); // Debug
        // dd($transactionData, $clientData, $clientAddress, $products, $split); // Debug

        $paymentService = PaymentServiceFactory::create();
        $response = $paymentService->generateQrCode($transactionData, $clientData, $clientAddress, $products, $split);
        // dd($response); // Debug
        // dd($response->getContent()); // Debug

        $json = $response->getData();
        // dd($json); // Debug

        $data = $json->original->success ? json_decode($json->original->data) : ['response' =>'ERROR'];

        // dd($data->paymentCode); // Debug

        if ($data->response === "OK") {
            try {
                $transaction->update(['id_transaction' => $data->idTransaction, 'status' => 'waiting']);

                // foreach ($data as $key => $value) {
                //     $data[$key] = json_decode($value, true);
                // }

                $webhook = WebhookTransactionLog::create([
                    'transaction_id' => $transaction->id,
                    'status' => 'WAITING',
                    'id_transaction' => $data->idTransaction,
                    'payment_code' => $data->paymentCode,
                    'payment_code_base64' => $data->paymentCodeBase64,
                    'message' => 'QR Code criado com sucesso!',
                    'response' => $data->response,
                    'body' => json_encode($data)
                ]);
            } catch (\Exception $e) {
                // dd($e->getMessage()); // Debug
                return response()->json(['message' => 'Erro ao criar log de transação'], 500);
            }

            return response(stripcslashes(json_encode([
                'id' => $data->idTransaction,
                'pix-code' => $data->paymentCode,
                'qr-code-base64' => $data->paymentCodeBase64,
                'message' => 'QR Code criado com sucesso!'
            ])), 201);
        } else {
            // dd($data); // Debug
            Transaction::where('id', $transaction->id)->update(['status' => 'failed']);
            Log::error('Erro ao criar QR Code', ['data' => $data, 'json' => $json, 'transaction' => $transaction, 'transactionData' => $transactionData, 'clientData' => $clientData, 'clientAddress' => $clientAddress, 'products' => $products, 'split' => $split]);
            return response()->json([
                'message' => 'Erro ao criar QR Code'
            ], 500);
        }
    }

    public function getPayment()
    {
        $id = request()->route('id');
        $transaction = Transaction::where('id_transaction', $id)->first();

        if ($transaction) {
            return response()->json([
                'transaction' => $transaction,
                'message' => 'success'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Pagamento não encontrado'
            ], 404);
        }
    }

    public function webhook() {
        $transaction = Transaction::where('id_transaction', request()->idTransaction)->first();

        if (!$transaction) {
            return response()->json([
                'message' => 'Transação não encontrada'
            ], 404);
        }

        // Save the request to the database
        WebhookTransactionLog::create([
            'status' => request()->statusTransaction === 'PAID_OUT' ? 'SUCCESS' : 'FAILED',
            'transaction_id' => $transaction->id,
            'statusTransaction' => request()->status,
            'id_transaction' => request()->idTransaction,
            'payment_code' => request()->paymentCode,
            'payment_code_base64' => "",
            'message' => "RECEIVED",
            'response' => "",
            'body' => json_encode(request()->all())
        ]);

        // Process the webhook data
        $idTransaction = request()->idTransaction;
        $statusTransaction = request()->statusTransaction;
        $value = request()->value;

        // Perform any additional processing or actions based on the webhook data
        // Update the transaction status
        if ($statusTransaction === 'PAID_OUT') {
            Transaction::where('id_transaction', $idTransaction)->update(['status' => 'success']);
        } else if ($statusTransaction === 'CHARGEBACK') {
            Transaction::where('id_transaction', $idTransaction)->update(['status' => 'failed']);
        }
        // Update balance of the user
        $transaction = Transaction::where('id_transaction', $idTransaction)->first();
        User::where('id', $transaction->user_id)->increment('balance', $value);

        // Return a response if needed
    }
}
