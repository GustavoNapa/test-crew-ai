<?php

namespace App\Http\Controllers\Banks;

use App\Http\Controllers\Controller;
use App\Interfaces\BankInterface;
use Illuminate\Http\Request;

class BanksController extends Controller 
{
    public function transfer(BankInterface $bankInterface, $accountId, $amount, $destinationAccountId) {
        // Transfer amount
    }

    public function balance(BankInterface $bankInterface, $accountId) {
        // Get balance
    }
}
