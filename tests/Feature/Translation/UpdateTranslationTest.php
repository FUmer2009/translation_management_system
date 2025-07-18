<?php

use App\EnumsTag;
use App\Models\Language;
use App\Models\Translation;
use Illuminate\Testing\Fluent\AssertableJson;

it('guest user can not update translation', function () {
    
    Language::factory()->create();

    $translation = Translation::factory()->create();

    $this->putJson(route('translations.update', ['translation' => $translation->id]))->assertUnauthorized();
});


it('user has to fill required fields', function () {

    loginUser();
    
    Language::factory()->create();
    
    $translation = Translation::factory()->create();

    $response = $this->putJson(route('translations.update', ['translation' => $translation->id]));

    $response->assertUnprocessable()->assertInvalid(['key','content', 'language_id']);
});

it('login user can update translation', function () {

    $this->assertDatabaseCount(Translation::class, 0);

    loginUser();
    
    $language = Language::factory()->create();

    $translation = Translation::factory()->create();

    $data = [
        'key'         => 'user_register',
        'content'     => 'User has been Registered',
        'tag'         => EnumsTag::WEB,
        'language_id' => $language->id
    ];

    $response = $this->putJson(route('translations.update', ['translation' => $translation->id]), $data);

    $response->assertStatus(202);

    $response->assertJson(fn(AssertableJson $json) => $json
        ->has('data', fn($json) => $json
            ->where('key', $data['key'])
            ->where('content', $data['content'])
            ->where('tag', $data['tag'])
            ->where('language_code', $language->code)
            ->etc()
        )
    );

    $this->assertDatabaseHas(Translation::class, [
        'key'        => $data['key'],
        'content'    => $data['content'],
        'tag'        => $data['tag'],
        'language_id' => $data['language_id']
    ]);
});