<?php

use App\Models\User;
use App\Models\UserAllowedIp;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;
use function PHPUnit\Framework\assertContainsOnlyInstancesOf;
use function PHPUnit\Framework\assertInstanceOf;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
uses(RefreshDatabase::class);

describe('register POST /api/v1/gateway/dynamic-qrcode', function () {
    it('has /api/v1/gateway/dynamic-qrcode post route', function () {
        $user = User::factory()->create();
        UserAllowedIp::create([
            'ip' => '127.0.0.1', 
            'user_id' => $user->id
        ]);

        Http::fake([
            'https://sandbox.ws.suitpay.app/api/v1/gateway/request-qrcode' => Http::response([
                "idTransaction" => "565e12fe-416e-4120-9528-fbf249c9b8c8",
                "paymentCode" => "00020101021226890014br.gov.bcb.pix2567brcode-h.sandbox.starkinfra.com/v2/fc4f41a71d454afa8d6fefa8699440395204000053039865802BR5918Suit Business Ltda6007Goiania62070503***6304B8FA",
                "response" => "OK",
                "paymentCodeBase64" => "iVBORw0KGgoAAAANSUhEUgAAAPoAAAD6AQAAAACgl2eQAAACw0lEQVR4Xu2XQZLrIAxE4SLo/reYo4iLwO8nUuN8L6ZmMemVKZcdw0tVRy0J0vbP46vdZ27jAc54gDMe4IzfAdlaX63PvcZokY37ZNIITF1zaWKurg8j5szOpBPQ69LszjFGZGTfIouxAjNHV8RC0dJyk1A/sLEqiJaonXEmjcDGLLQpRzIWAmvSCJCf8z7uWX1f/2OAIX9GoCslUdUTr3kXkDik+u2pZ18ncclfI7BT/aONvmKrgJIalmHLCqxRraMShgai1OkSeSWtAVDhjkZgNAMosxb99DthDAAuUTqjaXRaGRNVNzYg1TmUJ7TSE7RA+Xm4AAVnEq5XCa/KWfqIEdAi1VKm6a5HlGNOYGEVFs16VMTO5QMoWSKF0kX3uBevAcjK1qbIyLBGwNRO3s0yABUk3lcVLSrboKsZAVWIjheyTOJQV67pe9sIYNZOfJJK9bP2siycwMKpOtjg2UlevDMCWd2TAFVDpaXKqLQC7Gi4o729zzxqmXECQiRy4BFqJZmekm/VbQAwS0Wr6fKITY7gXSI/DxAS+taJVL2RvsF3XQAalSIUrYyifrTHAzsB+YQ3szInoYPWjkoboB1EwaFos0pWT/R+m+UA2EzVzBUbCa3tpcxyAgSIhEHb5ojDH1JiZgSwR5roY43dLIjdf5u7AQgydNHFtaKFybnvzSwDoJjgDO+wr1J+d9MAqFZ16+dPQB0uKF7WbQC7mAoGg1qtBUX0ZpYBWGQpxdJRqGnMooacAGmqWU42tViyS6MNwCKkak0j6vipeF0iDQCD0Kh4SRjFaN93/48D0ka6opKa3ezxSLx+xeeByZWNtJE2bqtOO90JZEk6biE2Ox8us0yAsoRKoXI6C9RxuIGu4Egcq4vEJUpOQFeVblmlhqrsjervPqCSVs0Tp0gdhYwumuh0AT+NBzjjAc54gDP+APgHKyUYafIGYkUAAAAASUVORK5CYII="
            ], 200)
        ]);

        actingAs($user, 'sanctum')
        ->postJson('/api/v1/gateway/dynamic-qrcode', [
                'requestNumber' => fake()->uuid(),
                'dueDate' => fake()->date(),
                'amount' => fake()->randomFloat(2, 1, 3),

            'client' => [
                'name' => fake()->name(),
                'document' => fake()->cpf(),
                'email' => fake()->email(),
            ]
        ], ['REMOTE_ADDR' => '127.0.0.1'])->assertStatus(201);
    });

    it('verify required fields', function () {
        $user = User::factory()->create();
        UserAllowedIp::create([
            'ip' => '127.0.0.1', 
            'user_id' => $user->id
        ]);

        actingAs($user, 'sanctum')
        ->postJson('/api/v1/gateway/dynamic-qrcode', [])
            ->assertJsonValidationErrors([
                'requestNumber' => 'O campo número da requisição é obrigatório.',
                'dueDate' => 'O campo data de vencimento é obrigatório.',
                'amount' => 'O campo valor é obrigatório.',
                'client.name' => 'O campo nome do cliente é obrigatório.',
                'client.document' => 'O campo documento do cliente é obrigatório.',
                'client.email' => 'O campo e-mail do cliente é obrigatório.',
            ]);
    });

    it('should return validate fields type', function () {
        $user = User::factory()->create();
        UserAllowedIp::create([
            'ip' => '127.0.0.1', 
            'user_id' => $user->id
        ]);

        $response = actingAs($user, 'sanctum')
        ->postJson('/api/v1/gateway/dynamic-qrcode', [
                'requestNumber' => fake()->numberBetween(1, 9),
                'dueDate' => fake()->text(25),
                'amount' => fake()->text(10),
                'shippingAmount' => fake()->text(10),
                'discountAmount' => fake()->text(10),
                'usernameCheckout' => fake()->numberBetween(1, 9),
                'callbackUrl' => fake()->text(),

            'client' => [
                'name' => fake()->numberBetween(1, 9),
                'document' => fake()->numberBetween(1, 9),
                'email' => fake()->text(),
                'phoneNumber' => fake()->numberBetween(1, 9),
                'address' => [
                    'codIbge' => fake()->numberBetween(1, 9),
                    'street' => fake()->numberBetween(1, 9),
                    'number' => fake()->randomNumber(4),
                    'complement' => fake()->numberBetween(1, 9),
                    'zipCode' => fake()->randomNumber(8),
                    'neighborhood' => fake()->numberBetween(1, 9),
                    'city' => fake()->numberBetween(1, 9),
                    'state' => fake()->numberBetween(1, 9),
                ],
            ],

            'products' => [
                [
                    'description' => fake()->numberBetween(1, 9),
                    'quantity' => fake()->text(8),
                    'value' => fake()->text(),
                ]
            ],

            'split' => [
                'username' => fake()->numberBetween(1, 9),
                'percentageSplit' => fake()->text(),
            ],
        ]);
        
        $response->assertJsonValidationErrors([
            'requestNumber' => 'O campo número da requisição deve ser uma string.',
            'dueDate' => 'O campo data de vencimento não é uma data válida.',
            'amount' => 'O campo valor deve ser um número.',
            'shippingAmount' => 'O campo taxa de entrega deve ser um número.', // opcional
            'discountAmount' => 'O campo valor do desconto deve ser um número.', // opcional
            'usernameCheckout' => 'O campo nome de usuário deve ser uma string.', // opcional
            'callbackUrl' => 'O campo URL de retorno tem um formato inválido.', // opcional

            'client.name' => 'O campo nome do cliente deve ser uma string.',
            'client.document' => 'O campo documento do cliente deve ser uma string.',
            'client.email' => 'O campo e-mail do cliente deve ser um endereço de e-mail válido.',
            'client.phoneNumber' => 'O campo telefone do cliente deve ser uma string.', // opcional

            'client.address.codIbge' => 'O campo código do IBGE deve ser uma string.', // opcional
            'client.address.street' => 'O campo endereço deve ser uma string.', // opcional
            'client.address.number' => 'O campo número deve ser uma string.', // opcional
            'client.address.complement' => 'O campo complemento deve ser uma string.', // opcional
            'client.address.zipCode' => 'O campo CEP deve ser uma string.', // opcional
            'client.address.neighborhood' => 'O campo bairro deve ser uma string.', // opcional
            'client.address.city' => 'O campo cidade deve ser uma string.', // opcional
            'client.address.state' => 'O campo estado deve ser uma string.', // opcional

            'products.0.description' => 'O campo descrição deve ser uma string.', // opcional
            'products.0.quantity' => 'O campo quantidade deve ser um número.', // opcional
            'products.0.value' => 'O campo valor deve ser um número.', // opcional

            'split.username' => 'O campo nome de usuário deve ser uma string.', // opcional
            'split.percentageSplit' => 'O campo porcentagem deve ser um número.', // opcional
        ]);
    });

    it('should return validate fields string lenght', function () {
        $user = User::factory()->create();
        UserAllowedIp::create([
            'ip' => '127.0.0.1', 
            'user_id' => $user->id
        ]);

        $response = actingAs($user, 'sanctum')
        ->postJson('/api/v1/gateway/dynamic-qrcode', [
                'requestNumber' => str_repeat('a', 255).fake()->uuid(),
                'dueDate' => str_repeat('a', 255).fake()->date(),
                'amount' => str_repeat('a', 255).fake()->randomFloat(2, 1, 9),
                'shippingAmount' => str_repeat('a', 255).fake()->randomFloat(2, 1, 9),
                'discountAmount' => str_repeat('a', 255).fake()->randomFloat(2, 1, 9),
                'usernameCheckout' => str_repeat('a', 255).fake()->name(),
                'callbackUrl' => str_repeat('a', 255).fake()->url('https'),

            'client' => [
                'name' => str_repeat('a', 255).fake()->name(),
                'document' => str_repeat('a', 255).fake()->cpf(),
                'email' => str_repeat('a', 255).fake()->email(),
                'phoneNumber' => str_repeat('a', 255).fake()->phoneNumber(),
                'address' => [
                    'codIbge' => str_repeat('a', 255).fake()->uuid(),
                    'street' => str_repeat('a', 255).fake()->streetAddress(),
                    'number' => (string)str_repeat('a', 255).fake()->randomNumber(4),
                    'complement' => str_repeat('a', 255).fake()->streetName(),
                    'zipCode' => (string)str_repeat('a', 255).fake()->randomNumber(8),
                    'neighborhood' => str_repeat('a', 255).fake()->streetName(),
                    'city' => str_repeat('a', 255).fake()->streetName(),
                    'state' => str_repeat('a', 255).fake()->streetName(),
                ],
            ],

            'products' => [
                [
                    'description' => str_repeat('a', 255).fake()->text(25),
                    'quantity' => str_repeat('a', 255).fake()->randomNumber(3),
                    'value' => str_repeat('a', 255).fake()->randomFloat(2, 1, 9),
                ]
            ],

            'split' => [
                'username' => str_repeat('a', 255).fake()->name(),
                'percentageSplit' => str_repeat('a', 255).fake()->randomNumber(2),
            ],
        ]);
        
        $response->assertJsonValidationErrors([
            'requestNumber' => 'O campo número da requisição não pode ser superior a 255 caracteres.',
            'dueDate' => 'O campo data de vencimento não é uma data válida.',
            'amount' => 'O campo valor é inválido.',
            'shippingAmount' => 'O campo taxa de entrega é inválido.', // opcional
            'discountAmount' => 'O campo valor do desconto deve ser um número.', // opcional
            'usernameCheckout' => 'O campo nome de usuário não pode ser superior a 255 caracteres', // opcional
            'callbackUrl' => 'O campo URL de retorno não pode ser superior a 255 caracteres', // opcional

            'client.name' => 'O campo nome do cliente não pode ser superior a 255 caracteres.',
            'client.document' => 'O campo documento do cliente não pode ser superior a 20 caracteres.',
            'client.email' => 'O campo e-mail do cliente não pode ser superior a 255 caracteres.',
            'client.phoneNumber' => 'O campo telefone do cliente não pode ser superior a 20 caracteres.', // opcional

            'client.address.codIbge' => 'O campo código do IBGE não pode ser superior a 255 caracteres.', // opcional
            'client.address.street' => 'O campo endereço não pode ser superior a 255 caracteres.', // opcional
            'client.address.number' => 'O campo número não pode ser superior a 10 caracteres.', // opcional
            'client.address.complement' => 'O campo complemento não pode ser superior a 255 caracteres.', // opcional
            'client.address.zipCode' => 'O campo CEP não pode ser superior a 10 caracteres.', // opcional
            'client.address.neighborhood' => 'O campo bairro não pode ser superior a 255 caracteres.', // opcional
            'client.address.city' => 'O campo cidade não pode ser superior a 255 caracteres.', // opcional
            'client.address.state' => 'O campo estado não pode ser superior a 255 caracteres.', // opcional

            'products.0.description' => 'O campo descrição não pode ser superior a 255 caracteres.', // opcional
            'products.0.quantity' => 'O campo quantidade deve ter entre 1 e 9 dígitos.', // opcional
            'products.0.value' => 'O campo valor é inválido.', // opcional

            'split.username' => 'O campo nome de usuário não pode ser superior a 255 caracteres.', // opcional
            'split.percentageSplit' => 'O campo porcentagem deve ter entre 1 e 9 dígitos.', // opcional
        ]);
    });

    it('save data in database', function () {
        $user = User::factory()->create();
        
        UserAllowedIp::create([
            'ip' => '127.0.0.1', 
            'user_id' => $user->id
        ]);

        Http::fake([
            'https://sandbox.ws.suitpay.app/api/v1/gateway/request-qrcode' => Http::response([
                "idTransaction" => "565e12fe-416e-4120-9528-fbf249c9b8c8",
                "paymentCode" => "00020101021226890014br.gov.bcb.pix2567brcode-h.sandbox.starkinfra.com/v2/fc4f41a71d454afa8d6fefa8699440395204000053039865802BR5918Suit Business Ltda6007Goiania62070503***6304B8FA",
                "response" => "OK",
                "paymentCodeBase64" => "iVBORw0KGgoAAAANSUhEUgAAAPoAAAD6AQAAAACgl2eQAAACw0lEQVR4Xu2XQZLrIAxE4SLo/reYo4iLwO8nUuN8L6ZmMemVKZcdw0tVRy0J0vbP46vdZ27jAc54gDMe4IzfAdlaX63PvcZokY37ZNIITF1zaWKurg8j5szOpBPQ69LszjFGZGTfIouxAjNHV8RC0dJyk1A/sLEqiJaonXEmjcDGLLQpRzIWAmvSCJCf8z7uWX1f/2OAIX9GoCslUdUTr3kXkDik+u2pZ18ncclfI7BT/aONvmKrgJIalmHLCqxRraMShgai1OkSeSWtAVDhjkZgNAMosxb99DthDAAuUTqjaXRaGRNVNzYg1TmUJ7TSE7RA+Xm4AAVnEq5XCa/KWfqIEdAi1VKm6a5HlGNOYGEVFs16VMTO5QMoWSKF0kX3uBevAcjK1qbIyLBGwNRO3s0yABUk3lcVLSrboKsZAVWIjheyTOJQV67pe9sIYNZOfJJK9bP2siycwMKpOtjg2UlevDMCWd2TAFVDpaXKqLQC7Gi4o729zzxqmXECQiRy4BFqJZmekm/VbQAwS0Wr6fKITY7gXSI/DxAS+taJVL2RvsF3XQAalSIUrYyifrTHAzsB+YQ3szInoYPWjkoboB1EwaFos0pWT/R+m+UA2EzVzBUbCa3tpcxyAgSIhEHb5ojDH1JiZgSwR5roY43dLIjdf5u7AQgydNHFtaKFybnvzSwDoJjgDO+wr1J+d9MAqFZ16+dPQB0uKF7WbQC7mAoGg1qtBUX0ZpYBWGQpxdJRqGnMooacAGmqWU42tViyS6MNwCKkak0j6vipeF0iDQCD0Kh4SRjFaN93/48D0ka6opKa3ezxSLx+xeeByZWNtJE2bqtOO90JZEk6biE2Ox8us0yAsoRKoXI6C9RxuIGu4Egcq4vEJUpOQFeVblmlhqrsjervPqCSVs0Tp0gdhYwumuh0AT+NBzjjAc54gDP+APgHKyUYafIGYkUAAAAASUVORK5CYII="
            ], 200)
        ]);

        $data = [
                'requestNumber' => fake()->uuid(),
                'dueDate' => fake()->date(),
                'amount' => fake()->randomFloat(2, 1, 9),
                'shippingAmount' => fake()->randomFloat(2, 1, 9),
                'discountAmount' => fake()->randomFloat(2, 1, 9),
                'usernameCheckout' => fake()->name(),
                'callbackUrl' => fake()->url('https'),

            'client' => [
                'name' => fake()->name(),
                'document' => fake()->cpf(),
                'email' => fake()->email(),
                'phoneNumber' => fake()->phoneNumber(),
                'address' => [
                    'codIbge' => fake()->uuid(),
                    'street' => fake()->streetAddress(),
                    'number' => (string)fake()->randomNumber(4),
                    'complement' => fake()->streetName(),
                    'zipCode' => (string)fake()->randomNumber(8),
                    'neighborhood' => fake()->streetName(),
                    'city' => fake()->streetName(),
                    'state' => fake()->streetName(),
                ],
            ],

            'products' => [
                [
                    'description' => fake()->text(25),
                    'quantity' => fake()->randomNumber(3),
                    'value' => fake()->randomFloat(2, 1, 9),
                ],
                [
                    'description' => fake()->text(25),
                    'quantity' => fake()->randomNumber(3),
                    'value' => fake()->randomFloat(2, 1, 9),
                ]
            ],

            // 'split' => [
            //     'username' => fake()->name(),
            //     'percentageSplit' => fake()->randomNumber(2),
            // ],
        ];
        // dd($data);
        actingAs($user, 'sanctum')
            ->postJson('/api/v1/gateway/dynamic-qrcode', $data, ['REMOTE_ADDR' => '127.0.0.1'])
            ->assertStatus(201);

        unset($data['client']);
        // unset($data['client']['address']);
        unset($data['products']);
        unset($data['split']);

        // dd($data);

        assertDatabaseHas('transactions', $data);
    });

    it('should return pix-code', function () {
        $user = User::factory()->create();
        
        UserAllowedIp::create([
            'ip' => '127.0.0.1', 
            'user_id' => $user->id
        ]);

        $data = [
                'requestNumber' => fake()->uuid(),
                'dueDate' => fake()->date(),
                'amount' => fake()->randomFloat(2, 1, 9),
                'shippingAmount' => fake()->randomFloat(2, 1, 9),
                'discountAmount' => fake()->randomNumber(3),
                'usernameCheckout' => fake()->name(),
                'callbackUrl' => fake()->url('https'),

            'client' => [
                'name' => fake()->name(),
                'document' => fake()->cpf(),
                'email' => fake()->email(),
                'phoneNumber' => fake()->phoneNumber(),
            ],

            'address' => [
                'codIbge' => fake()->uuid(),
                'street' => fake()->streetAddress(),
                'number' => (string)fake()->randomNumber(4),
                'complement' => fake()->streetName(),
                'zipCode' => (string)fake()->randomNumber(8),
                'neighborhood' => fake()->streetName(),
                'city' => fake()->streetName(),
                'state' => fake()->streetName(),
            ],

            'products' => [
                'description' => fake()->text(25),
                'quantity' => fake()->randomNumber(3),
                'price' => fake()->randomFloat(2, 1, 9),
            ],

            // 'split' => [
            //     'username' => fake()->name(),
            //     'percentageSplit' => fake()->randomNumber(2),
            // ],
        ];

        actingAs($user, 'sanctum')
            ->postJson('/api/v1/gateway/dynamic-qrcode', $data, ['REMOTE_ADDR' => '127.0.0.1'])
                ->assertStatus(201)
                ->assertJsonStructure([
                    'id',
                    'pix-code',
                    'message'
                ]);

        unset($data['client']);
        unset($data['address']);
        unset($data['products']);
        unset($data['split']);

        assertDatabaseHas('transactions', $data);
    });

    it('should return error when user is not allowed', function () {
        $user = User::factory()->create();
        
        actingAs($user, 'sanctum')
            ->postJson('/api/v1/gateway/dynamic-qrcode', [])
                ->assertStatus(403);
    });

    it('should call a the interface Bank', function () {
        $user = User::factory()->create();
        
        UserAllowedIp::create([
            'ip' => '127.0.0.1', 
            'user_id' => $user->id
        ]);
        
        $data = [
            'requestNumber' => fake()->uuid(),
            'dueDate' => fake()->date(),
            'amount' => fake()->randomFloat(2, 1, 9),
            'shippingAmount' => fake()->randomFloat(2, 1, 9),
            'discountAmount' => fake()->randomNumber(3),
            'usernameCheckout' => fake()->name(),
            'callbackUrl' => fake()->url('https'),

            'client' => [
                'name' => fake()->name(),
                'document' => fake()->cpf(),
                'email' => fake()->email(),
                'phoneNumber' => fake()->phoneNumber(),
            ],

            'address' => [
                'codIbge' => fake()->uuid(),
                'street' => fake()->streetAddress(),
                'number' => (string)fake()->randomNumber(4),
                'complement' => fake()->streetName(),
                'zipCode' => (string)fake()->randomNumber(8),
                'neighborhood' => fake()->streetName(),
                'city' => fake()->streetName(),
                'state' => fake()->streetName(),
            ],

            'products' => [
                'description' => fake()->text(25),
                'quantity' => fake()->randomNumber(3),
                'price' => fake()->randomFloat(2, 1, 9),
            ],

            'split' => [
                'username' => fake()->name(),
                'percentageSplit' => fake()->randomNumber(2),
            ],
        ];
        $response = actingAs($user, 'sanctum')
                        ->postJson('/api/v1/gateway/dynamic-qrcode', $data, ['REMOTE_ADDR' => '127.0.0.1'])
                            ->assertStatus(201);

        $response->assertStatus(201);

        // assertInstanceOf('App\Interfaces\BankInterface', $response);
        
        unset($data['client']);
        unset($data['address']);
        unset($data['products']);
        unset($data['split']);

        assertDatabaseHas('transactions', $data);
    })->skip('teste de integração com API externa');

    it('should send data to external API and verify response', function () {
        $user = User::factory()->create();
        $data = [
                'requestNumber' => fake()->uuid(),
                'dueDate' => fake()->date(),
                'amount' => fake()->randomFloat(2, 1, 9),
                'shippingAmount' => fake()->randomFloat(2, 1, 9),
                'discountAmount' => fake()->randomNumber(3),
                'usernameCheckout' => fake()->name(),
                'callbackUrl' => fake()->url('https'),

            'client' => [
                'name' => fake()->name(),
                'document' => fake()->cpf(),
                'email' => fake()->email(),
                'phoneNumber' => fake()->phoneNumber(),
            ],

            'address' => [
                'codIbge' => fake()->uuid(),
                'street' => fake()->streetAddress(),
                'number' => (string)fake()->randomNumber(4),
                'complement' => fake()->streetName(),
                'zipCode' => (string)fake()->randomNumber(8),
                'neighborhood' => fake()->streetName(),
                'city' => fake()->streetName(),
                'state' => fake()->streetName(),
            ],

            'products' => [
                [
                    'description' => fake()->text(25),
                    'quantity' => fake()->randomNumber(3),
                    'price' => fake()->randomFloat(2, 1, 9),
                ],
                [
                    'description' => fake()->text(25),
                    'quantity' => fake()->randomNumber(3),
                    'price' => fake()->randomFloat(2, 1, 9),
                ]
            ],

            'split' => [
                'username' => fake()->name(),
                'percentageSplit' => fake()->randomNumber(2),
            ],
        ];
        $response = post('https://sandbox.ws.suitpay.app/api/v1/gateway/request-qrcode',
        $data,
        [
            'ci' => 'testesandbox_1687443996536',
            'cs' => '5b7d6ed3407bc8c7efd45ac9d4c277004145afb96752e1252c2082d3211fe901177e09493c0d4f57b650d2b2fc1b062d'
        ]);

        // dd($response->json());
        
        $response->assertStatus(200);
    })->skip('teste de integração com API externa');

    it('should update status to failed when response is error', function () {
        $user = User::factory()->create();
        
        UserAllowedIp::create([
            'ip' => '127.0.0.1',
            'user_id' => $user->id
        ]);

        $data = [
            'requestNumber' => fake()->uuid(),
            'dueDate' => fake()->date(),
            'amount' => fake()->randomFloat(2, 1, 9),
            'shippingAmount' => fake()->randomFloat(2, 1, 9),
            'discountAmount' => fake()->randomNumber(3),
            'usernameCheckout' => fake()->name(),
            'callbackUrl' => fake()->url('https'),

            'client' => [
                'name' => fake()->name(),
                'document' => fake()->cpf(),
                'email' => fake()->email(),
                'phoneNumber' => fake()->phoneNumber(),
            ],

            'address' => [
                'codIbge' => fake()->uuid(),
                'street' => fake()->streetAddress(),
                'number' => (string)fake()->randomNumber(4),
                'complement' => fake()->streetName(),
                'zipCode' => (string)fake()->randomNumber(8),
                'neighborhood' => fake()->streetName(),
                'city' => fake()->streetName(),
                'state' => fake()->streetName(),
            ],

            'products' => [
                'description' => fake()->text(25),
                'quantity' => fake()->randomNumber(3),
                'price' => fake()->randomFloat(2, 1, 9),
            ],

            // 'split' => [
            //     'username' => fake()->name(),
            //     'percentageSplit' => fake()->randomNumber(2),
            // ],
        ];

        Http::fake([
            'https://sandbox.ws.suitpay.app/api/v1/gateway/request-qrcode' => Http::response([
                'response' => 'ERROR'
            ], 500)
        ]);

        actingAs($user, 'sanctum')
            ->postJson('/api/v1/gateway/dynamic-qrcode', $data, ['REMOTE_ADDR' => '127.0.0.1'])
                ->assertJsonStructure([
                    'message'
                ]);

        unset($data['client']);
        unset($data['address']);
        unset($data['products']);
        unset($data['split']);
        $data['status'] = 'failed';

        assertDatabaseHas('transactions', $data);
    });
});