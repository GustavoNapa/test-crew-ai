<?php

use App\Http\Services\Helpers;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserContact;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

describe('save company on user POST /conta/dados_empresa', function () {
    it('has /conta/dados_empresa POST route', function () {
        $user = User::factory()->create();
        
        $data = generateCompany();

        $data['user_id'] = $user->id;

        actingAs($user)
        ->post('/conta/dados_empresa', $data)->assertRedirect('/dashboard');
    });
    
    it('verify required fields', function () {
        $user = User::factory()->create();
        UserContact::factory()->create(['user_id' => $user->id, 'contact' => fake()->phoneNumber(), 'type' => 'cell_phone']);
        UserContact::factory()->create(['user_id' => $user->id, 'contact' => fake()->email(), 'type' => 'email']);
        UserAddress::factory()->create(['user_id' => $user->id]);

        actingAs($user)
        ->post('/conta/dados_empresa', [])
        ->assertSessionHasErrors([
            'cnpj' => 'O CNPJ é obrigatório!',
            'company_name' => 'O Nome da Empresa é obrigatório!',
            'fantasy_name' => 'O Nome Fantasia é obrigatório!',
            'municipal_registration' => 'O Registro Municipal é obrigatório!',
            'state_registration' => 'O Registro Estadual é obrigatório!',
        ]);
    });

    it('save company in db', function () {
        $user = User::factory()->create();
        UserContact::factory()->create(['user_id' => $user->id, 'contact' => fake()->phoneNumber(), 'type' => 'cell_phone']);
        UserContact::factory()->create(['user_id' => $user->id, 'contact' => fake()->email(), 'type' => 'email']);
        UserAddress::factory()->create(['user_id' => $user->id]);

        $data = generateCompany();

        $data['user_id'] = $user->id;

        actingAs($user)
        ->post('/conta/dados_empresa', $data)->assertRedirect('/dashboard');

        $data['cnpj'] = Helpers::removeCaracteresEspeciais($data['cnpj']);
        assertDatabaseHas('user_companies', $data);
    });
});

function generateCompany()
{
    return [
        'cnpj' => fake()->numberBetween(10000000000000, 99999999999999),
        'company_name' => fake()->company(),
        'fantasy_name' => fake()->company(),
        'municipal_registration' => fake()->numberBetween(10000, 99999),
        'state_registration' => fake()->numberBetween(10000, 99999)
    ];
}