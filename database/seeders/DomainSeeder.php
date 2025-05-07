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
                'name' => 'Realistic'
            ],
            [
                'id' => 2,
                'name' => 'Investigative'
            ],
            [
                'id' => 3,
                'name' => 'Artistic'
            ],
            [
                'id' => 4,
                'name' => 'Social'
            ],
            [
                'id' => 5,
                'name' => 'Enterprising'
            ],
            [
                'id' => 6,
                'name' => 'Conventional'
            ],
        ];

        foreach ($domains as $domain) {
            Domain::create($domain);
        }
    }
}
