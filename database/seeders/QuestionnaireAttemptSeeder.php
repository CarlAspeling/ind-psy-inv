<?php

namespace Database\Seeders;

use App\Models\QuestionnaireAttempt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionnaireAttemptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questionnaireAttempts = [
            'questionnaire_id' => 1,
        ];

        QuestionnaireAttempt::create($questionnaireAttempts);
    }
}
