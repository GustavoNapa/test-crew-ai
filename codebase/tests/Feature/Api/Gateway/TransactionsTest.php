<?php

use App\Models\UserAllowedIp;
use Illuminate\Support\Facades\Http;

describe('List GET /api/v1/gateway/dynamic-qrcode', function () {
    it('has /api/v1/gateway/dynamic-qrcode get route', function () {
        $user = App\Models\User::factory()->create();

        UserAllowedIp::create([
            'ip' => '127.0.0.1', 
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->get('/api/v1/gateway/dynamic-qrcode', ['REMOTE_ADDR' => '127.0.0.1']);

        $response->assertStatus(200);
    });

    // generate a test to show the transactions
    it('shows the transactions', function () {
        $user = App\Models\User::factory()->create();

        UserAllowedIp::create([
            'ip' => '127.0.0.1',
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->get('/api/v1/gateway/dynamic-qrcode', ['REMOTE_ADDR' => '127.0.0.1']);

        $response->assertJsonStructure([
            'transactions',
            'message'
        ]);

        $response->assertJsonFragment([
            'message' => 'success'
        ]);

        $response->assertJsonFragment([
            'transactions' => []
        ]);

        $response->assertStatus(200);

    });

    it('show the transaction by id', function () {
        $user = App\Models\User::factory()->create();

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
                'phoneNumber' => fake()->phoneNumber()
            ]
        ];

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/v1/gateway/dynamic-qrcode', $data, ['REMOTE_ADDR' => '127.0.0.1'])
            ->assertStatus(201);
                
        $response = $this->actingAs($user, 'sanctum')
            ->get('/api/v1/gateway/dynamic-qrcode/565e12fe-416e-4120-9528-fbf249c9b8c8', ['REMOTE_ADDR' => '127.0.0.1']);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'transaction',
            'message'
        ]);

        $response->assertJsonFragment([
            'message' => 'success'
        ]);
    });
});