<?php

use App\Models\User;

use function Pest\Laravel\actingAs;

it('has /conta/dados_contato page', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get('/conta/dados_contato')
        ->assertStatus(200);
});
