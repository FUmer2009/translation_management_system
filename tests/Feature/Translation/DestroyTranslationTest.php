<?php

use App\Models\Language;
use App\Models\Translation;

it('guest user can not delete translation', function () {
    
    Language::factory()->create();

    $translation = Translation::factory()->create();

    $this->putJson(route('translations.destroy', ['translation' => $translation->id]))->assertUnauthorized();
});

it('login user can delete translation', function () {

    $this->assertDatabaseCount(Translation::class, 0);

    loginUser();
    
    Language::factory()->create();

    $translation = Translation::factory()->create();

    $response = $this->deleteJson(route('translations.destroy', ['translation' => $translation->id]));

    $response->assertStatus(204);

    $this->assertDatabaseMissing(Translation::class, [
        'id' => $translation->id
    ]);
});