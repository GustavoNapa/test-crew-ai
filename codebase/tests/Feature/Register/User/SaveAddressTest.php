<?php

use App\Http\Services\Helpers;
use App\Models\User;
use App\Models\UserContact;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

describe('save address on user POST /conta/endereco', function () {
    it('has /conta/endereco POST route', function () {
        $user = User::factory()->create();
        
        $data = generateAddress();

        $data['user_id'] = $user->id;

        actingAs($user)
        ->post('/conta/endereco', $data)->assertRedirect('/dashboard');
    });

    it('verify required fields', function () {
        $user = User::factory()->create();
        UserContact::factory()->create(['user_id' => $user->id, 'contact' => fake()->phoneNumber(), 'type' => 'cell_phone']);
        UserContact::factory()->create(['user_id' => $user->id, 'contact' => fake()->email(), 'type' => 'email']);
        // UserContact::factory()->create(['user_id' => $user->id, 'contact' => fake()->phoneNumber(), 'type' => 'cell_phone']);
        // UserContact::factory()->create(['user_id' => $user->id, 'contact' => fake()->email(), 'type' => 'email']);

        actingAs($user)
        ->post('/conta/endereco', [])
        ->assertSessionHasErrors([
            'postal_code' => 'O CEP é obrigatório!',
            'street' => 'O Endereço é obrigatório!',
            'number' => 'O Número é obrigatório!',
            'city' => 'O Cidade é obrigatório!',
            'state' => 'O Estado é obrigatório!',
        ]);
    });

    it('save address in db', function () {
        $user = User::factory()->create();
        UserContact::factory()->create(['user_id' => $user->id, 'contact' => fake()->phoneNumber(), 'type' => 'cell_phone']);
        UserContact::factory()->create(['user_id' => $user->id, 'contact' => fake()->email(), 'type' => 'email']);
        
        $data = generateAddress();
        $data['user_id'] = $user->id;

        actingAs($user)
        ->post('/conta/endereco', $data)->assertRedirect('/dashboard');

        $data['postal_code'] = Helpers::removeCaracteresEspeciais($data['postal_code']);
        assertDatabaseHas('user_addresses', $data);
    });
});

function generateAddress()
{
    return [
        'postal_code' => fake()->postcode(),
        'street' => fake()->streetAddress(),
        'number' => fake()->numberBetween(1, 99999),
        'neighborhood' => fake()->streetAddress(),
        'number' => fake()->numberBetween(10, 999),
        'state' => fake()->streetAddress(),
        'city' => fake()->city(),
    ];
}