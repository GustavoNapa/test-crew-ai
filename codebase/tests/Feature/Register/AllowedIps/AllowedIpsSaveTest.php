<?php

use App\Http\Services\Helpers;
use App\Livewire\AllowedIps\AllowedIps;
use App\Models\User;
use App\Models\UserAllowedIp;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

describe('save allowed ips on user POST /user/allowed-ips', function () {
    it('has /user/allowed-ips POST route', function () {
        $user = User::factory()->create(['type' => 'ADMIN']);
        
        $data = generateIp();
        
        // $component = Livewire::test(AllowedIps::class, 'saveIp');

        // $component->assertStatus(200);

        actingAs($user)
            ->post('/user/allowed-ips', $data)
            ->assertRedirect(route('allowedIps'));

        // $allowedIps = UserAllowedIp::get();

        // Livewire::test(AllowedIps::class, ['allowedIps'])
        //     ->set('allowedIps', '127.0.0.1')
        //     ->call('saveIp')
        //     ->assertStatus(200);
    });

    it('verify required fields', function () {
        $user = User::factory()->create(['type' => 'ADMIN']);

        actingAs($user)
            ->post('/user/allowed-ips')
            ->assertSessionHasErrors([
                'ip' => 'O IP é obrigatório!',
            ]);
    });

    it('save allowed ips in db', function () {
        $user = User::factory()->create(['type' => 'ADMIN']);
        $data = generateIp();

        actingAs($user)
            ->post('/user/allowed-ips', $data)
            ->assertRedirect(route('allowedIps'));

        assertDatabaseHas('user_allowed_ips', $data);
    });
});

function generateIp()
{
    return [
        'ip' => fake()->ipv4(),
    ];
}