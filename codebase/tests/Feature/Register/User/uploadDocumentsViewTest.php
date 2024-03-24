<?php

use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserCompany;
use App\Models\UserContact;

use function Pest\Laravel\actingAs;

it('has /conta/enviar_documentos page', function () {
    $user = User::factory()->create();
    UserContact::factory()->create(['user_id' => $user->id, 'contact' => fake()->phoneNumber(), 'type' => 'cell_phone']);
    UserContact::factory()->create(['user_id' => $user->id, 'contact' => fake()->email(), 'type' => 'email']);
    UserAddress::factory()->create(['user_id' => $user->id]);
    UserCompany::factory()->create(['user_id' => $user->id]);

    actingAs($user)
        ->get('/conta/enviar_documentos')
        ->assertStatus(200);
});
