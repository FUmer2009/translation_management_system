<?php

use App\Models\Language;
use App\Models\Translation;

it('guest user can not view translation', function () {
    
    $this->getJson(route('translations.index'))->assertUnauthorized();
});

it('login user can view translation list', function () {

    $this->assertDatabaseCount(Translation::class, 0);

    loginUser();
    
    Language::factory()->create();

    Translation::factory(3)->create();

    $response = $this->getJson(route('translations.index'));

    $response->assertStatus(200)->assertJsonCount(3, 'data');
});