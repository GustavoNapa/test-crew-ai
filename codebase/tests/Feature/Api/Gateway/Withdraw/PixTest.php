<?php

use App\Models\User;
use App\Models\UserAllowedIp;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

describe('register POST /api/v1/gateway/withdraw/pix', function () {
    it('has /api/v1/gateway/withdraw/pix post route', function () {
        $user = User::factory()->create();
        UserAllowedIp::create([
            'ip' => '127.0.0.1', 
            'user_id' => $user->id
        ]);

        actingAs($user, 'sanctum')
        ->postJson('/api/v1/gateway/withdraw/pix', [
            'requestNumber' => fake()->numberBetween(1000000, 999999999999),
            'amount' => fake()->randomFloat(2),
            'key' => fake()->numberBetween(1000000, 999999999999),
            'key_type' => 'document',
            'client' => [
                'name' => fake()->name(),
                'document' => fake()->cpf(),
                'email' => fake()->email(),
                'phoneNumber' => fake()->phoneNumber()
            ],
        ], ['REMOTE_ADDR' => '127.0.0.1'])->assertStatus(200);
    });

    it('verify required fields', function () {
        $user = User::factory()->create();
        UserAllowedIp::create([
            'ip' => '127.0.0.1', 
            'user_id' => $user->id
        ]);

        actingAs($user, 'sanctum')
        ->postJson('/api/v1/gateway/withdraw/pix', [])
            ->assertJsonValidationErrors([
                'requestNumber' => 'O numero da requisição é obrigatório',
                'key' => 'A chave PIX é obrigatória',
                'key_type' => 'O tipo da chave PIX é obrigatória',
                'amount' => "O valor é obrigatório",
                'client.name' => 'O campo nome do cliente é obrigatório.',
                'client.document' => 'O campo documento do cliente é obrigatório.',
                'client.email' => 'O campo e-mail do cliente é obrigatório.',
            ]);
    });

    it('save data in database', function () {
        $user = User::factory()->create();
        UserAllowedIp::create([
            'ip' => '127.0.0.1', 
            'user_id' => $user->id
        ]);

        $data = [
            'requestNumber' => fake()->numberBetween(1000000, 999999999999),
            'amount' => fake()->randomFloat(2),
            'key' => fake()->numberBetween(1000000, 999999999999),
            'key_type' => 'document',
            'client' => [
                'name' => fake()->name(),
                'document' => fake()->cpf(),
                'email' => fake()->email(),
                'phoneNumber' => fake()->phoneNumber()
            ],
        ];

        actingAs($user, 'sanctum')
        ->postJson('/api/v1/gateway/withdraw/pix', $data, ['REMOTE_ADDR' => '127.0.0.1'])->assertStatus(200);
        unset($data['key_type']);
        unset($data['client']);
        assertDatabaseHas('transactions', $data);
    });

    it('should have a valid key_type', function () {
        $user = User::factory()->create();
        UserAllowedIp::create([
            'ip' => '127.0.0.1', 
            'user_id' => $user->id
        ]);

        $data = [
            'requestNumber' => fake()->numberBetween(1000000, 999999999999),
            'amount' => fake()->randomFloat(2),
            'key' => fake()->numberBetween(1000000, 999999999999),
            'key_type' => 'teste',
        ];

        actingAs($user, 'sanctum')
        ->postJson('/api/v1/gateway/withdraw/pix', $data, ['REMOTE_ADDR' => '127.0.0.1'])
        ->assertJsonValidationErrors([
            'key_type' => 'O tipo da chave PIX é inválida',
        ]);
    });

    it('should return pix-code', function () {
        $data = generateData();
        post('/api/v1/gateway/withdraw/pix', $data)->assertRedirect('/dashboard');
        // unset($data['g-recaptcha-response']);
        unset($data['password']);
        unset($data['password_confirmation']);
        unset($data['terms']);
        assertDatabaseHas('users', $data);
    })->skip('INACABADO');
});