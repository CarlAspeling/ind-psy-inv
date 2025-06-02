<?php

namespace Database\Seeders;

use App\Models\Domain;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $domains = [
            [
                'id' => 1,
                'name' => 'Realistic',
                'code' => 'R'
            ],
            [
                'id' => 2,
                'name' => 'Investigative',
                'code' => 'I'
            ],
            [
                'id' => 3,
                'name' => 'Artistic',
                'code' => 'A'
            ],
            [
                'id' => 4,
                'name' => 'Social',
                'code' => 'S'
            ],
            [
                'id' => 5,
                'name' => 'Enterprising',
                'code' => 'E'
            ],
            [
                'id' => 6,
                'name' => 'Conventional',
                'code' => 'C'
            ],
        ];

        foreach ($domains as $domain) {
            Domain::create($domain);
        }
    }
}
