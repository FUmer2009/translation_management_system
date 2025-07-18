<?php

use App\Models\Language;

it('guest user can not view language', function () {
    
    $this->getJson(route('languages.index'))->assertUnauthorized();
});

it('login user can view language list', function () {

    $this->assertDatabaseCount(Language::class, 0);

    loginUser();
    
    Language::factory(3)->create();

    $response = $this->getJson(route('languages.index'));

    $response->assertStatus(200)->assertJsonCount(3, 'data');
});