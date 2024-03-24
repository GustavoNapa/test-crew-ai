<?php

it('has /register page', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});
