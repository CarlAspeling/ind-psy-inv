<?php

namespace Database\Seeders;

use App\Models\ResponseOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResponseOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $responseOptions = [
            [
                'id' => 1,
                'response_set_id' => 1,
                'value' => 1,
                'label' => 'Strongly Disagree',
                'order' => 0,
            ],
            [
                'id' => 2,
                'response_set_id' => 1,
                'value' => 2,
                'label' => 'Disagree',
                'order' => 1,
            ],
            [
                'id' => 3,
                'response_set_id' => 1,
                'value' => 3,
                'label' => 'Neither agree nor disagree',
                'order' => 2,
            ],
            [
                'id' => 4,
                'response_set_id' => 1,
                'value' => 4,
                'label' => 'Agree',
                'order' => 3,
            ],
            [
                'id' => 5,
                'response_set_id' => 1,
                'value' => 5,
                'label' => 'Strongly Agree',
                'order' => 4,
            ]
        ];

        foreach($responseOptions as $r) {
            ResponseOption::create($r);
        }
    }
}
