<?php

namespace App\Services;

use App\Models\Domain;
use App\Models\QuestionnaireAttempt;

class ResultsService
{
    public function calculateResults(QuestionnaireAttempt $attempt): array
    {
        $domainScores = [];

        // Check if attempt has responses
        if ($attempt->responses->isEmpty()) {
            throw new \Exception('Cannot calculate results: no responses found for this attempt.');
        }

        foreach ($attempt->responses as $response) {
            $domainId = $response->question->domain_id;
            $value = $response->responseOption->value;

            if (!isset($domainScores[$domainId])) {
                $domainScores[$domainId] = 0;
            }
            $domainScores[$domainId] += $value;
        }

        arsort($domainScores);

        $topThreeDomainIds = array_slice(array_keys($domainScores), 0, 3);

        // Handle case where we don't have enough domains
        if (empty($topThreeDomainIds)) {
            throw new \Exception('Cannot calculate results: no domain scores found.');
        }

        // Ensure we have exactly 3 domains (pad with remaining domains if needed)
        if (count($topThreeDomainIds) < 3) {
            $allDomains = Domain::pluck('id')->toArray();
            $missingDomains = array_diff($allDomains, $topThreeDomainIds);
            $topThreeDomainIds = array_merge($topThreeDomainIds, array_slice($missingDomains, 0, 3 - count($topThreeDomainIds)));
        }

        $domainCodes = Domain::whereIn('id', $topThreeDomainIds)
            ->orderByRaw("FIELD(id, " . implode(',', $topThreeDomainIds) . ")")
            ->pluck('code')
            ->toArray();

        $threeLetterCode = implode('', $domainCodes);

        return [
            'three_letter_code' => $threeLetterCode,
            'domain_scores' => $domainScores,
            'top_three_domains' => $domainCodes,
        ];
    }
}
