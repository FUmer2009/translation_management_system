<?php

use App\Models\Language;
use Illuminate\Testing\Fluent\AssertableJson;

it('guest user can not view language', function () {
    
    $language = Language::factory()->create();

    $this->putJson(route('languages.show', ['language' => $language->id]))->assertUnauthorized();
});

it('login user can view language', function () {

    $this->assertDatabaseCount(Language::class, 0);

    loginUser();
    
    $language = Language::factory()->create();

    $response = $this->getJson(route('languages.show', ['language' => $language->id]));

    $response->assertStatus(200);

    $response->assertJson(fn(AssertableJson $json) => $json
        ->has('data', fn($json) => $json
            ->where('code', $language->code)
            ->where('name', $language->name)
            ->etc()
        )
    );
});