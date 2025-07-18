<?php

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

it('user has to fill required fields', function () {
    
    $response = $this->postJson(route('register'));

    $response->assertUnprocessable()->assertInvalid(['name', 'email', 'password']);
});

it('register user', function () {

    $this->assertDatabaseCount(User::class, 0);
    
    $data = [
            'name'     => 'Test Uset',
            'email'    => 'test@test.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
    
    $response = $this->postJson(route('register'), $data);

    $response->assertStatus(201);

    $response->assertJson(fn(AssertableJson $json) => $json
        ->has('data', fn($json) => $json
            ->where('name', $data['name'])
            ->where('email', $data['email'])
            ->missing('password')
            ->etc()
        )
    );

    $this->assertDatabaseHas(User::class, [
        'name' => $data['name'],
        'email' => $data['email']
    ]);
});