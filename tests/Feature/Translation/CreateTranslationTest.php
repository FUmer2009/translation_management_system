<?php

use App\EnumsTag;
use App\Models\Language;
use App\Models\Translation;
use Illuminate\Testing\Fluent\AssertableJson;

it('guest user can not create translation', function () {

    $this->postJson(route('translations.store'))->assertUnauthorized();

});

it('user has to fill required fields', function () {

    loginUser();
    
    $response = $this->postJson(route('translations.store'));

    $response->assertUnprocessable()->assertInvalid(['key','content', 'language_id']);
});

it('login user can create translation', function () {

    $this->assertDatabaseCount(Translation::class, 0);
  
    loginUser();
    
    $language = Language::factory()->create();

    $data = [
        'key'         => 'user_register',
        'content'     => 'User has been Registered',
        'tag'         => EnumsTag::WEB,
        'language_id' => $language->id
    ];
    
    $response = $this->postJson(route('translations.store'), $data);

    $response->assertStatus(201);

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
        'key'         => $data['key'],
        'content'     => $data['content'],
        'tag'         => $data['tag'],
        'language_id' => $data['language_id']
    ]);
});