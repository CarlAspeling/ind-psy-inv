<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    public function show()
    {
        $questionnaire = Questionnaire::with([
            'questions.responseSet.responseOptions'
        ])->findOrFail(1);

        $questions = $questionnaire->questions->map(function ($question) {
            $responseOptions = $question->responseSet
                ? $question->responseSet->responseOptions->sortBy('order')->values()->map(function ($option) {
                    return [
                        'id' => $option->id,
                        'label' => $option->label,
                        'value' => $option->value,
                    ];
                })->values()
                : [];

            return [
                'id' => $question->id,
                'question_text' => $question->question_text,
                'response_options' => $responseOptions,
            ];
        });

        return response()->json([
            'id' => $questionnaire->id,
            'name' => $questionnaire->name,
            'description' => $questionnaire->description,
            'questions' => $questions,
        ]);
    }
}
