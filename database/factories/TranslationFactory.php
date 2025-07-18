<?php

namespace Database\Factories;

use App\EnumsTag;
use App\Models\Language;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key'         => Str::slug(fake()->text(maxNbChars: 20), '_'),
            'content'     => fake()->paragraph(),
            'tag'         => fake()->randomElement(array_column(EnumsTag::cases(), 'value')),
            'language_id' => fake()->randomElement(Language::pluck('id'))
        ];
    }
}
