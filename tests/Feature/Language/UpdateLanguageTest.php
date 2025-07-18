<?php

use App\Models\Language;
use Illuminate\Testing\Fluent\AssertableJson;

it('guest user can not update language', function () {
    
    $language = Language::factory()->create();

    $this->putJson(route('languages.update', ['language' => $language->id]))->assertUnauthorized();
});


it('user has to fill required fields', function () {

    loginUser();
    
    $language = Language::factory()->create();

    $response = $this->putJson(route('languages.update', ['language' => $language->id]));

    $response->assertUnprocessable()->assertInvalid(['code','name']);
});

it('login user can update language', function () {

    $this->assertDatabaseCount(Language::class, 0);

    loginUser();
    
    $language = Language::factory()->create();

    $data = [
        'code' => 'en',
        'name' => 'English'
    ];

    $response = $this->putJson(route('languages.update', ['language' => $language->id]), $data);

    $response->assertStatus(202);

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