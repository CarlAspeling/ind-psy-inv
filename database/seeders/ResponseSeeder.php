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
            'questionnaire_attempt_id' => 1,
            'question_id' => 1,
            'response_option_id' => 1,
        ];

        Response::create($responses);
    }
}
