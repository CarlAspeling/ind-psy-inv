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
                'code' => 'R',
                'description' => 'Prefers hands-on activities that involve building, fixing, or working with tools, machinery, or the outdoors. Often enjoys physical work, practical tasks, and tangible outcomes.',
            ],
            [
                'id' => 2,
                'name' => 'Investigative',
                'code' => 'I',
                'description' => 'Drawn to solving problems, analyzing information, and thinking abstractly. Enjoys research, learning, and exploring ideas through observation and critical thinking.'
            ],
            [
                'id' => 3,
                'name' => 'Artistic',
                'code' => 'A',
                'description' => 'Thrives on creativity, self-expression, and open-ended tasks. Enjoys working in unstructured environments involving art, music, writing, or design.'
            ],
            [
                'id' => 4,
                'name' => 'Social',
                'code' => 'S',
                'description' => 'Motivated by helping others, teaching, counseling, or providing care. Enjoys interpersonal interaction and values empathy, cooperation, and communication.'
            ],
            [
                'id' => 5,
                'name' => 'Enterprising',
                'code' => 'E',
                'description' => 'Energized by leadership, persuasion, and taking initiative. Enjoys influencing others, driving results, and engaging in business, sales, or project-based roles.'
            ],
            [
                'id' => 6,
                'name' => 'Conventional',
                'code' => 'C',
                'description' => 'Prefers structured tasks, organization, and precision. Values order, reliability, and consistency, often thriving in environments with rules and clear expectations.'
            ],
        ];

        foreach ($domains as $domain) {
            Domain::create($domain);
        }
    }
}
