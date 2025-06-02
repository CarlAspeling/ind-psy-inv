<?php

namespace Database\Seeders;

use App\Models\ResponseSet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResponseSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $responseSets = [
            'id' => 1,
            'name' => 'Likert Scale (5-item)'
        ];

        ResponseSet::create($responseSets);
    }
}
