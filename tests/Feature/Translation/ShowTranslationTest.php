<?php

use App\Models\Language;
use App\Models\Translation;
use Illuminate\Testing\Fluent\AssertableJson;

it('guest user can not view translation', function () {
    
    Language::factory()->create();

    $translation = Translation::factory()->create();

    $this->putJson(route('translations.show', ['translation' => $translation->id]))->assertUnauthorized();
});

it('login user can view translation', function () {

    $this->assertDatabaseCount(Translation::class, 0);

    loginUser();
    
    $language = Language::factory()->create();

    $translation = Translation::factory()->create();

    $response = $this->getJson(route('translations.show', ['translation' => $translation->id]));

    $response->assertStatus(200);

    $response->assertJson(fn(AssertableJson $json) => $json
        ->has('data', fn($json) => $json
            ->where('key', $translation->key)
            ->where('content', $translation->content)
            ->where('tag', $translation->tag)
            ->where('language_code', $language->code)
            ->etc()
        )
    );
});