<?php

namespace App\Factories;

use App\Gateways\SuitPayGateway;
use App\Http\Services\PaymentService;
use App\Interfaces\PaymentGatewayInterface;

class PaymentServiceFactory
{
    public static function create(): PaymentService
    {
        // Implemente sua lógica de seleção de banco aqui
        // Futuramente, ler de uma tabela users_gateways no banco de dados
        // para saber qual gateway o usuário está utilizando
        $bank = 'SuitPay';
        switch ($bank) {
            case 'SuitPay':
                $gateway = new SuitPayGateway();
                break;
            // Adicione mais casos para outros bancos, se necessário
            default:
                throw new \InvalidArgumentException('Banco não suportado: ' . $bank);
        }

        if (!($gateway instanceof PaymentGatewayInterface)) {
            throw new \InvalidArgumentException('Gateway inválido');
        }

        return new PaymentService($gateway);
    }
}