<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AllowedIpController;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
use App\Models\UserAllowedIp;
use App\Models\UsersAllowedIp;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware([
    'auth:sanctum',
    'userAuth',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/conta-em-aprovacao', function () {
        return view('account.pending');
    })->name('account.pending');

    Route::get('/conta-bloqueada', function () {
        return view('account.banned');
    })->name('account.banned');

    Route::get('/conta-rejeitada', function () {
        return view('account.rejected');
    })->name('account.rejected');

    Route::get('/conta-inativa', function () {
        return view('account.inactive');
    })->name('account.inactive');

    // IP ALLOWED
    Route::get('/user/allowed-ips', function () {
        $allowedIps = UserAllowedIp::where('user_id', auth()->user()->id)->get();
        return view('allowedIps.index')
        ->with('allowedIps', $allowedIps);
    })->name('allowedIps');

    Route::post('/user/allowed-ips', [AllowedIpController::class, 'saveIp'])->name('saveIp');

    // TRANSACTION
    Route::get('/conta/transacoes', [TransactionController::class, 'getTransactions'])->name('transactions');
    Route::get('/conta/transacao/{id}', [TransactionController::class, 'showTransactionDetails'])->name('transactionDetails');
    Route::get('/conta/transacoes/aprovar/{id}', [TransactionController::class, 'approveTransaction'])->name('approveTransaction');
    // Route::get('/conta/transacoes/{id}', [TransactionController::class, 'getTransaction'])->name('transaction');

    // REGISTRO
    Route::get('/conta/dados_contato', function () {
        return view('account.setContactData');
    })->name('account.registerContactData');

    Route::get('/conta/endereco', function () {
        return view('account.setAddress');
    })->name('account.registerAddress');

    Route::get('/conta/dados_empresa', function () {
        return view('account.setCompanyData');
    })->name('account.registerCompanyData');

    Route::get('/conta/enviar_documentos', function () {
        return view('account.documentUpload');
    })->name('account.sendDocuments');

    Route::post('/conta/dados_contato', [AccountController::class, 'setContactData'])->name('account.setContactData');
    Route::post('/conta/endereco', [AccountController::class, 'setAddress'])->name('account.setAddress');
    Route::post('/conta/dados_empresa', [AccountController::class, 'setCompanyData'])->name('account.setCompanyData');
    Route::post('/conta/enviar_documentos', [AccountController::class, 'sendDocuments'])->name('account.saveDocuments');
});
