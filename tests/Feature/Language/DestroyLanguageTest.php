<?php

use App\Models\Language;

it('guest user can not delete language', function () {
    
    $language = Language::factory()->create();

    $this->putJson(route('languages.destroy', ['language' => $language->id]))->assertUnauthorized();
});

it('login user can delete language', function () {

    $this->assertDatabaseCount(Language::class, 0);

    loginUser();
    
    $language = Language::factory()->create();

    $response = $this->deleteJson(route('languages.destroy', ['language' => $language->id]));

    $response->assertStatus(204);

    $this->assertDatabaseMissing(Language::class, [
        'id' => $language->id
    ]);
});