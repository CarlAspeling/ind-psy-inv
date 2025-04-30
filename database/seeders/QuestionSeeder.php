<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Option;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            [
                'questionnaire_id' => 1,
                'response_set_id' => 1,
                'question_text' => 'I like doing things with my hands',
                'domain' => 'Realistic',
            ],
            [
                'questionnaire_id' => 1,
                'response_set_id' => 1,
                'question_text' => 'I like researching things',
                'domain' => 'Investigative',
            ],
            [
                'questionnaire_id' => 1,
                'response_set_id' => 1,
                'question_text' => 'I like painting',
                'domain' => 'Artistic',
            ],
            [
                'questionnaire_id' => 1,
                'response_set_id' => 1,
                'question_text' => 'I like helping people',
                'domain' => 'Social',
            ],
            [
                'questionnaire_id' => 1,
                'response_set_id' => 1,
                'question_text' => 'I like selling things',
                'domain' => 'Enterprising',
            ],
            [
                'questionnaire_id' => 1,
                'response_set_id' => 1,
                'question_text' => 'I like predictability',
                'domain' => 'Conventional',
            ]
        ];

        foreach ($questions as $q) {
            Question::create($q);
        }
    }
}
