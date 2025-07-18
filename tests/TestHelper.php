<?php
namespace Tests;

use App\Models\User;
use Laravel\Sanctum\Sanctum;

class TestHelper {

    public static function login(User $user = null) {
        $user = $user ?? User::factory()->create();

        Sanctum::actingAs($user);

        return $user;
    }
}