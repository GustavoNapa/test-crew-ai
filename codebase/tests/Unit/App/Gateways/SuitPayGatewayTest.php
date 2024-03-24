<?php

use App\Gateways\SuitPayGateway;
use Illuminate\Support\Facades\Http;

it('deve fazer uma requisição para o endpoint /v1/gateway/request-qrcode', function () {
    // Mock das variáveis de ambiente
    // putenv('APP_ENV=production');
    // putenv('SUITPAY_URL=https://sua-url-de-producao.com');
    // putenv('SUITPAY_CLIENT_ID=seu-client-id-producao');
    // putenv('SUITPAY_CLIENT_SECRET=seu-client-secret-producao');

    // Mock da resposta da API SuitPay
    // Http::fake([
    //     'https://sua-url-de-producao.com/v1/gateway/request-qrcode' => Http::response(['data' => 'retorno da API SuitPay - produção'], 200),
    // ]);

    // Instância da classe SuitPayBank
    $suitPay = new SuitPayGateway();

    // Execução do método request
    $response = $suitPay->generateQrCode([], []);

    // Verificação da resposta
    assert(200, $response->status());
    assert('{"data":"retorno da API SuitPay - produção"}', $response->content());
})->skip('Teste incompleto');