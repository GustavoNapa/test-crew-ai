<?php

namespace App\Http\Controllers\Api\webhook;

use App\Http\Controllers\Controller;
use App\Models\WebhookTransactionLog;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function view(Request $request) {
        $transactionLogs = WebhookTransactionLog::all();
        return response()->json([
            'transaction_logs' => $transactionLogs,
            'message' => 'success'
        ], 200);
    }
}
