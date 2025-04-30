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
            'name' => 'Response Set 1',
        ];

        ResponseSet::create($responseSets);
    }
}
