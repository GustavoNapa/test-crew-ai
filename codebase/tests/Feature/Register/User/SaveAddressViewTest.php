<?php

use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserContact;

use function Pest\Laravel\actingAs;

it('has /conta/endereco page', function () {
    $user = User::factory()->create();
    UserContact::factory()->create(['user_id' => $user->id, 'contact' => fake()->phoneNumber(), 'type' => 'cell_phone']);
    UserContact::factory()->create(['user_id' => $user->id, 'contact' => fake()->email(), 'type' => 'email']);

    actingAs($user)
        ->get('/conta/endereco')
        ->assertStatus(200);
});
