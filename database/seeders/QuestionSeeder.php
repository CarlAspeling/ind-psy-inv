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
                'question_text' => 'I like doing things with my hands',
                'domain' => 'Realistic',
                'input_type' => 'radio',
                'options' => ['Yes', 'No'],
            ],
            [
                'question_text' => 'I like researching things',
                'domain' => 'Investigative',
                'input_type' => 'radio',
                'options' => ['Yes', 'No'],
            ],
            [
                'question_text' => 'I like painting',
                'domain' => 'Artistic',
                'input_type' => 'radio',
                'options' => ['Yes', 'No'],
            ],
            [
                'question_text' => 'I like helping people',
                'domain' => 'Social',
                'input_type' => 'radio',
                'options' => ['Yes', 'No'],
            ],
            [
                'question_text' => 'I like selling things',
                'domain' => 'Enterprising',
                'input_type' => 'radio',
                'options' => ['Yes', 'No'],
            ],
            [
                'question_text' => 'I like predictability',
                'domain' => 'Conventional',
                'input_type' => 'radio',
                'options' => ['Yes', 'No'],
            ],
        ];

        foreach ($questions as $q) {
            $question = Question::create([
                'questionnaire_id' => 1, // Ensure this exists!
                'question_text' => $q['question_text'],
                'domain' => $q['domain'],
                'input_type' => $q['input_type'],
            ]);

            foreach ($q['options'] as $opt) {
                $question->options()->create(['option' => $opt]);
            }
        }
    }
}
