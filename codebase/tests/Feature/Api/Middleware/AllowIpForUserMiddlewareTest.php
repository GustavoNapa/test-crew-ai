<?php

use App\Models\User;
use App\Models\UserAllowedIp;
use Illuminate\Support\Facades\Http;

use function Pest\Laravel\actingAs;

describe('Middleware IP register', function () {
    it('has showld have return 200 when IP is valid', function () {
        $user = User::factory()->create();
        
        UserAllowedIp::factory()->create([
            'ip' => '127.0.0.1',
            'user_id' => $user->id
        ]);

        actingAs($user, 'sanctum')
            ->get('/api/v1')
            ->assertStatus(200);
    });

    it('has showld have return 403 when IP is invalid', function () {
        $user = User::factory()->create();

        actingAs($user, 'sanctum')
        ->get('/api/v1')->assertStatus(403);
    });
});