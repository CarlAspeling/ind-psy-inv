<?php

namespace App\Services;

use App\Models\Domain;
use App\Models\QuestionnaireAttempt;

class ResultsService
{
    public function calculateResults(QuestionnaireAttempt $attempt): array
    {
        $domainScores = [];

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
