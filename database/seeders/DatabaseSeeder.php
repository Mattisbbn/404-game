<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gameboard;
use Database\Factories\GameboardFactory;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        foreach (GameboardFactory::boardEntries() as $entry) {
            Gameboard::factory()->create([
                'score' => $entry['score'],
                'position' => $entry['position'],
                'category' => $entry['category'],
            ]);
        }
    }
}
