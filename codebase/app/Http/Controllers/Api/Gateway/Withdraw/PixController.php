<?php

namespace App\Http\Controllers\Api\Gateway\Withdraw;

use App\Http\Controllers\Controller;
use App\Http\Requests\GatewayWithdrawPixRequest;
use App\Http\Services\Helpers;
use App\Models\Client;
use App\Models\ClientAddress;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PixController extends Controller
{
    public function create(GatewayWithdrawPixRequest $request) {
        $validated = $request->validated();

        // dd($validated); // Debug

        $clientData = $validated['client'];
        $clientAddress = $validated['client']['address'] ?? null;

        $clientData['document'] = Helpers::numbersOnly($clientData['document']);
        
        $data = [
            'type' => 'withdrawn',
            'status' => 'pending',
            'requestNumber' => $validated['requestNumber'],
            'amount' => $validated['amount'],
            'dueDate' => date('Y-m-d'), // '2024-03-08'
            'key' => $validated['key'],
            'key_type' => $validated['key_type'],
        ];
        
        // dd($data); // Debug

        if (Client::where('document', $clientData['document'])->exists()) {
            $client = Client::where('document', $clientData['document'])->first();

            $clientId = $client->id;

            // dd($client); // Debug

            if (!empty($clientAddress)) {
                if (ClientAddress::where('client_id', $clientId)->exists()) {
                    try {
                        $clientAddress['client_id'] = $clientId;
                        ClientAddress::where('client_id', $clientId)->update($clientAddress);
                        // dd($address); // Debug
                    } catch (\Exception $e) {
                        // dd($e->getMessage()); // Debug
                        return response()->json(['message' => 'Erro ao atualizar o endereço'], 500);
                    }
                } else {
                    try {
                        $clientAddress['client_id'] = $clientId;
                        ClientAddress::create($clientAddress);
                        // dd($address); // Debug
                    } catch (\Exception $e) {
                        // dd($e->getMessage()); // Debug
                        return response()->json(['message' => 'Erro ao salvar o endereço'], 500);
                    }
                }
                
            }
        } else {
            try {
                $client = Client::create($clientData);
                $clientId = $client->id;
                // dd($client); // Debug
            } catch (\Exception $e) {
                // dd($e); // Debug
                return response()->json(['message' => 'Erro ao criar cliente'], 500);
            }
            
            if (!empty($clientAddress)) {
                try {
                    $clientAddress['client_id'] = $clientId;
                    $address = ClientAddress::create($clientAddress);
                    $addressId = $address->id;
                    // dd($address); // Debug
                } catch (\Exception $e) {
                    // dd($e); // Debug
                    return response()->json(['message' => 'Erro ao salvar o endereço'], 500);
                }
            }
        }

        $data['client_id'] = $clientId;
        $data['user_id'] = auth()->user()->id;
        // dd($data); // Debug

        $transaction = Transaction::create($data);

        // dd($transaction); // Debug
        if ($transaction) {
            return response()->json([
                'transaction' => $transaction,
                'client' => $client,
                'message' => 'Solicitação de saque realizada com sucesso'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Saque não realizado'
            ], 404);
        }
    }

    public function pixPayment(Request $request) {
        return response()->json([
            'request' => $request->all(),
            'message' => 'teste'
        ], 200);
    }
}
