<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gameboard>
 */
class GameboardFactory extends Factory
{
    /**
     * Shared definition of the fixed board entries.
     *
     * @return array<int, array{score: int, position: int, category: ?string}>
     */
    public static function boardEntries(): array
    {
        return [
            ['score' => 1,  'position' => 0,  'category' => ''],
            ['score' => 1,  'position' => 1,  'category' => 'social_media'],
            ['score' => 1,  'position' => 2,  'category' => 'phishing'],
            ['score' => 1,  'position' => 3,  'category' => 'password'],
            ['score' => 1,  'position' => 4,  'category' => 'phishing'],
            ['score' => 1,  'position' => 5,  'category' => 'phishing'],
            ['score' => 1,  'position' => 6,  'category' => 'social_media'],
            ['score' => 1,  'position' => 7,  'category' => 'password'],
            ['score' => 1,  'position' => 8,  'category' => 'password'],
            ['score' => 1,  'position' => 9,  'category' => 'social_media'],
            ['score' => -2, 'position' => 10, 'category' => 'malus'],
            ['score' => 1,  'position' => 11, 'category' => 'phishing'],
            ['score' => 1,  'position' => 12, 'category' => 'social_media'],
            ['score' => 1,  'position' => 13, 'category' => 'password'],
            ['score' => 1,  'position' => 14, 'category' => 'social_media'],
            ['score' => 1,  'position' => 15, 'category' => 'password'],
            ['score' => 1,  'position' => 16, 'category' => 'phishing'],
            ['score' => 1,  'position' => 17, 'category' => 'social_media'],
            ['score' => 1,  'position' => 18, 'category' => 'prison'],
            ['score' => 1,  'position' => 19, 'category' => 'password'],
            ['score' => 1,  'position' => 20, 'category' => 'social_media'],
            ['score' => 1,  'position' => 21, 'category' => 'phishing'],
            ['score' => 1,  'position' => 22, 'category' => 'password'],
            ['score' => 1,  'position' => 23, 'category' => 'password'],
            ['score' => 1,  'position' => 24, 'category' => 'social_media'],
            ['score' => 1,  'position' => 25, 'category' => 'phishing'],
            ['score' => 1,  'position' => 26, 'category' => 'password'],
            ['score' => 2,  'position' => 27, 'category' => 'bonus'],
            ['score' => 1,  'position' => 28, 'category' => 'password'],
            ['score' => 1,  'position' => 29, 'category' => 'social_media'],
            ['score' => 1,  'position' => 30, 'category' => 'social_media'],
            ['score' => 1,  'position' => 31, 'category' => 'phishing'],
            ['score' => 1,  'position' => 32, 'category' => 'password'],
            ['score' => 1,  'position' => 33, 'category' => 'password'],
        ];
    }

    /**
     * Define the model's default state.
     *
     * @return array{score: int, position: int, category: ?string}
     */
    public function definition(): array
    {
        static $entryIndex = 0;

        $entries = self::boardEntries();
        $entry = $entries[$entryIndex % count($entries)];
        $entryIndex++;

        return $entry;
    }
}
