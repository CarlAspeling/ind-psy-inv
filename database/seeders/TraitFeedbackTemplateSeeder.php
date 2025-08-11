<?php

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\TraitFeedbackTemplate;
use Illuminate\Database\Seeder;

class TraitFeedbackTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $feedbackData = [
            'Realistic' => [
                'primary' => 'You take the lead when it comes to practical, hands-on tasks. You enjoy working with tools, machines, or physical systems, often solving problems through direct action.',
                'supporting' => 'You bring stability and groundedness to teams. You’re dependable when tasks require follow-through and practical judgment.',
                'modulating' => 'You temper big ideas with realism, helping ensure that projects stay feasible and rooted in the real world.'
            ],
            'Investigative' => [
                'primary' => 'You are driven by curiosity and analysis. You enjoy figuring out how things work and are energized by research, theories, and solving complex problems.',
                'supporting' => 'You support projects by adding depth, data, and critical thinking. You help sharpen the team’s understanding.',
                'modulating' => 'You question assumptions and slow down decision-making just enough to ensure it’s thoughtful and evidence-based.'
            ],
            'Artistic' => [
                'primary' => 'Creativity is your superpower. You enjoy expressing yourself and bringing new, original ideas into the world.',
                'supporting' => 'You inspire others with imaginative approaches, and help generate fresh ways to tackle problems.',
                'modulating' => 'You help break monotony and inject personality and flair into otherwise rigid systems or routines.'
            ],
            'Social' => [
                'primary' => 'You are people-oriented, thriving in environments where you can support, teach, or connect with others.',
                'supporting' => 'You bring emotional intelligence and team cohesion. You often mediate, support, and uplift others.',
                'modulating' => 'You help humanize goals or plans that may otherwise overlook empathy or well-being.'
            ],
            'Enterprising' => [
                'primary' => 'You are action-oriented and persuasive. You thrive in leadership roles and are energized by challenges and results.',
                'supporting' => 'You bring momentum and motivation to group work, encouraging others to move forward.',
                'modulating' => 'You push ideas toward execution, ensuring they don’t get stuck in planning or analysis.'
            ],
            'Conventional' => [
                'primary' => 'You value order, structure, and detail. You thrive in systems that are clearly defined and well-organized.',
                'supporting' => 'You bring consistency and accuracy, helping teams stay on track and avoid chaos.',
                'modulating' => 'You provide discipline and reliability, helping anchor flexible or abstract approaches in real workflows.'
            ],
        ];

        foreach ($feedbackData as $domainName => $roles) {
            $domain = Domain::where('name', $domainName)->first();

            foreach ($roles as $role => $description) {
                TraitFeedbackTemplate::create([
                    'domain_id' => $domain->id,
                    'role' => $role,
                    'description' => $description,
                ]);
            }
        }
    }
}
