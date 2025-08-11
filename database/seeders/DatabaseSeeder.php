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
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com'
        ]);

        Questionnaire::factory()->create([
            'id' => 1,
            'name' => 'RIASEC Career Interest Inventory',
            'description' => 'This inventory is designed to help you identify your career interests.',
            'type' => 'Career Interest Inventory'
        ]);

        $this->call([
            AdminUserSeeder::class,
            DomainSeeder::class,
            TraitFeedbackTemplateSeeder::class,
            ResponseSetSeeder::class,
            QuestionSeeder::class,
            ResponseOptionSeeder::class,
            QuestionnaireAttemptSeeder::class, ## to note that not currently in use, but keeping for later
            ResponseSeeder::class
        ]);
    }
}
