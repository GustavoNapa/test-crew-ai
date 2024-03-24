<?php

namespace App\Http\Controllers;

use App\Factories\PaymentServiceFactory;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WebhookTransactionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class TransactionController extends Controller
{
    public function getTransactions(Request $request)
    {
        $transactions = Transaction::query();

        $perPage = 10;

        // search by user
        if ($request->user) {
            $user = User::where('name', 'like', '%' . $request->user . '%')->first();
            if ($user) {
                $transactions = $transactions->where('user_id', $user->id);
            }
        }

        // search by type
        if ($request->type) {
            $transactions = $transactions->where('type', $request->type);
        }

        // search by status
        if ($request->status) {
            $transactions = $transactions->where('status', $request->status);
        }

        // search by between dates
        if ($request->start_date && $request->end_date) {
            $transactions = $transactions->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // order by
        if ($request->order_by) {
            $transactions = $transactions->orderBy($request->order_by, $request->order);
        }

        // per page
        if ($request->per_page) {
            $perPage = $request->per_page;
        }

        
        $transactions = $transactions->with('user')->orderBy('created_at', 'desc')->paginate($perPage)->appends(request()->query());

        return view('transactions.index', compact('transactions'));
    }

    public function showTransactionDetails($id)
    {
        $transaction = Transaction::find($id);
        return response()->json($transaction);
    }

    function approveTransaction(Request $request) {
        RateLimiter::hit($request->id, 1);
        $transactionId = $request->id;
        $transaction = Transaction::find($transactionId);

        if(RateLimiter::tooManyAttempts($request->id, 1)) {
            Log::alert("Tentativa de aprovar transação muito recente", ['transaction_id' => $transactionId]);
            return redirect()->route('transactions')->withErrors('error', 'Tentativa de aprovar transação muito recente');
        }

        if (!$transaction) {
            return redirect()->route('transactions')->withErrors('error', 'Transação não encontrada');
        }

        if ($transaction->status !== 'pending') {
            return redirect()->route('transactions')->withErrors('error', 'Transação já aprovada');
        }
        
        $paymentService = PaymentServiceFactory::create();
        $withdraw = $paymentService->withdrawPix(
            $transaction->key, 
            $transaction->key_type, 
            $transaction->amount
        );

        // dd($withdraw, $transaction->client);

        if ($withdraw->status() !== 200) {
            WebhookTransactionLog::create([
                'transaction_id' => $transaction->id,
                'status' => 'error',
                'response' => $withdraw->json(),
            ]);
            return redirect()->route('transactions')->withErrors('error', 'Erro ao aprovar a transação');
        }

        WebhookTransactionLog::create([
            'transaction_id' => $transaction->id,
            'status' => 'success',
            'response' => $withdraw->json(),
        ]);

        $transaction->status = 'waiting';
        $transaction->save();

        return redirect()->route('transactions')->with('success', 'Transação aprovada com sucesso, processando pagamento');
    }

    public function webhook(){
        $data = request()->all();
        $transaction = Transaction::where('id_transaction', $data['id_transaction'])->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transação não encontrada'], 404);
        }

        $transaction->update([
            'status' => $data['status'],
            'id_transaction' => $data['id_transaction'],
            'payment_code' => $data['payment_code'],
            'payment_code_base64' => $data['payment_code_base64'],
            'message' => $data['message'],
            'response' => $data['response'],
        ]);

        // Update transaction status
        if ($data['status'] === 'SUCCESS') {
            $transaction->status = 'success';
            $transaction->save();
        } else if ($data['status'] === 'FAILED') {
            $transaction->status = 'failed';
            $transaction->save();
        }

        // update balance of the user
        $user = User::where('id', $transaction->user_id)->first();
        $user->balance += $transaction->amount;
        $user->save();

        return response()->json(['message' => 'success'], 200);
    }
}
