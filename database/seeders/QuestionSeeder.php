<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            [
                'id' => 1,
                'domain_id' => 1,
                'questionnaire_id' => 1,
                'response_set_id' => 1,
                'question_text' => 'I like doing things with my hands',
            ],
            [
                'id' => 2,
                'domain_id' => 2,
                'questionnaire_id' => 1,
                'response_set_id' => 1,
                'question_text' => 'I like researching things',
            ],
            [
                'id' => 3,
                'domain_id' => 3,
                'questionnaire_id' => 1,
                'response_set_id' => 1,
                'question_text' => 'I like painting',
            ],
            [
                'id' => 4,
                'domain_id' => 4,
                'questionnaire_id' => 1,
                'response_set_id' => 1,
                'question_text' => 'I like helping people',
            ],
            [
                'id' => 5,
                'domain_id' => 5,
                'questionnaire_id' => 1,
                'response_set_id' => 1,
                'question_text' => 'I like selling things',
            ],
            [
                'id' => 6,
                'domain_id' => 6,
                'questionnaire_id' => 1,
                'response_set_id' => 1,
                'question_text' => 'I like predictability',
            ]
        ];

        foreach ($questions as $q) {
            Question::create($q);
        }
    }
}
