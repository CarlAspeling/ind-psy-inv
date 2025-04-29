<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

        Questionnaire::factory()->create([
            'name' => 'Test questionnaire',
            'description' => 'This is a test questionnaire',
            'type' => 'Test',
        ]);

        $this->call([
            QuestionSeeder::class,
        ]);
    }
}
