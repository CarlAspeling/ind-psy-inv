<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'response_option_id' => 'required|exists:response_options,id',
            'questionnaire_attempt_id' => 'required|exists:questionnaire_attempts,id'
        ]);

        $response = Response::updateOrCreate(
            [
                'question_id' => $validated['question_id'],
                'questionnaire_attempt_id' => $validated['questionnaire_attempt_id'],
            ],
            [
                'response_option_id' => $validated['response_option_id'],
            ]
        );

        return response()->json(['success' => true, 'response_id' => $response->id]);
    }
}
