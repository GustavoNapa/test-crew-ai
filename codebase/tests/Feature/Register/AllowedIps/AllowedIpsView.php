<?php

use App\Models\User;

use function Pest\Laravel\actingAs;

it('has /user/allowed-ips page', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get('/user/allowed-ips')
        ->assertStatus(200);
});
