<?php

use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserContact;

use function Pest\Laravel\actingAs;

it('has /conta/dados_empresa page', function () {
    $user = User::factory()->create();
    UserContact::factory()->create(['user_id' => $user->id, 'contact' => fake()->phoneNumber(), 'type' => 'cell_phone']);
    UserContact::factory()->create(['user_id' => $user->id, 'contact' => fake()->email(), 'type' => 'email']);
    UserAddress::factory()->create(['user_id' => $user->id]);

    actingAs($user)
        ->get('/conta/dados_empresa')
        ->assertStatus(200);
});
