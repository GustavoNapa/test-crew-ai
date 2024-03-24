<?php

use App\Http\Services\Helpers;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

describe('save contact data on user POST /conta/dados_contato', function () {
    it('has /conta/dados_contato POST route', function () {
        $user = User::factory()->create();

        $data = [
            'contacts' => [
                'cell_phone' => fake()->phoneNumber(),
                'email' => fake()->email(),
            ]
        ];

        actingAs($user)
            ->post('/conta/dados_contato', $data)
            ->assertRedirect('/dashboard');
    });

    it('verify required fields', function () {
        $user = User::factory()->create();

        actingAs($user)
        ->post('/conta/dados_contato', [])
        ->assertSessionHasErrors([
            'contacts.cell_phone' => 'O Celular é obrigatório!',
            'contacts.email' => 'O E-mail é obrigatório!',
        ]);
    });

    it('save contact in db', function () {
        $user = User::factory()->create();

        $data = [
            'contacts' => [
                'cell_phone' => fake()->phoneNumber(),
                'email' => fake()->email(),
            ]
        ];

        actingAs($user)
            ->post('/conta/dados_contato', $data)
            ->assertRedirect('/dashboard');

        $data['contacts']['cell_phone'] = Helpers::removeCaracteresEspeciais($data['contacts']['cell_phone']);

        assertDatabaseHas('user_contacts', ['contact' => $data['contacts']['cell_phone']]);
        assertDatabaseHas('user_contacts', ['contact' => $data['contacts']['email']]);
    });
});
