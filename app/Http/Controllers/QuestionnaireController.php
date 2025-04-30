<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    public function show()
    {
        return response()->json(
            Questionnaire::with('questions')->findOrFail(1)
        );
    }
//    public function show($id)
//    {
//        $questionnaire = Questionnaire::with('questions')->findOrFail($id);
//
//        return response()->json([
//            'questionnaires' => [
//                'id' => $questionnaire->id,
//                'title' => $questionnaire->name,
//                'description' => $questionnaire->description,
//                'type' => $questionnaire->type,
//            ],
//            'questions' => $questionnaire->questions->map(function ($q) {
//                return [
//                    'id' => $q->id,
//                    'question' => $q->question_text,
//                    'options' => json_decode($q->options),
//                ];
//            }),
//        ]);
//    }


}
