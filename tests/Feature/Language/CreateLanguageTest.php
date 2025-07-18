<?php

use App\Models\Language;
use Illuminate\Testing\Fluent\AssertableJson;

it('guest user can not create language', function () {

    $this->postJson(route('languages.store'))->assertUnauthorized();

});

it('user has to fill required fields', function () {

    loginUser();
    
    $response = $this->postJson(route('languages.store'));

    $response->assertUnprocessable()->assertInvalid(['code','name']);
});

it('login user can create language', function () {

    $this->assertDatabaseCount(Language::class, 0);
  
    loginUser();
    
    $data = [
        'code' => 'en',
        'name' => 'English'
    ];
    
    $response = $this->postJson(route('languages.store'), $data);

    $response->assertStatus(201);

    $response->assertJson(fn(AssertableJson $json) => $json
        ->has('data', fn($json) => $json
            ->where('code', $data['code'])
            ->where('name', $data['name'])
            ->etc()
        )
    );

    $this->assertDatabaseHas(Language::class, [
        'code' => $data['code'],
        'name' => $data['name']
    ]);
});