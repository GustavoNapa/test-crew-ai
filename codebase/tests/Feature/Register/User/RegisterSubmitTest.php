<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

describe('register POST /register', function () {
    it('has /register post route', function () {
        post('/register', generateData())->assertRedirect('/dashboard');
    });

    it('verify required fields', function () {
        post('/register', [])
            ->assertSessionHasErrors([
                // 'g-recaptcha-response' => 'O recapcha é obrigatório',
                'password' => 'O campo senha é obrigatório.',
                'name' => 'O campo nome é obrigatório.',
                'email' => 'O campo email é obrigatório.',
                'terms' => 'O campo terms deve ser aceito.'
            ]);
    });

    it('save data in database', function () {
        $data = generateData();
        post('/register', $data)->assertRedirect('/dashboard');
        // unset($data['g-recaptcha-response']);
        unset($data['password']);
        unset($data['password_confirmation']);
        unset($data['terms']);
        assertDatabaseHas('users', $data);
    });
});

function generateData() {
    return [
        // 'g-recaptcha-response' => 'test-6LdcCxsoAAAAALH-pdp9YQBE_USUDBZdAlC8XZgH',
        'password' => 'Pa$$w0rd',
        'password_confirmation' => 'Pa$$w0rd',
        'name' => fake()->name(),
        'email' => fake()->email(),
        'terms' => 'on'
    ];
}