<?php

namespace Database\Seeders;

use App\Models\Response;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $responses = [
            [
            'id' => 1,
            'questionnaire_attempt_id' => 1,
            'question_id' => 1,
            'response_option_id' => 5,
            ],
            [
                'id' => 2,
                'questionnaire_attempt_id' => 1,
                'question_id' => 2,
                'response_option_id' => 4,
            ],
            [
                'id' => 3,
                'questionnaire_attempt_id' => 1,
                'question_id' => 3,
                'response_option_id' => 3,
            ],
            [
                'id' => 4,
                'questionnaire_attempt_id' => 1,
                'question_id' => 4,
                'response_option_id' => 1,
            ],
            [
                'id' => 5,
                'questionnaire_attempt_id' => 1,
                'question_id' => 5,
                'response_option_id' => 1,
            ],
            [
                'id' => 6,
                'questionnaire_attempt_id' => 1,
                'question_id' => 6,
                'response_option_id' => 1,
            ],
        ];

        foreach($responses as $r) {
            Response::create($r);
        }
    }
}
