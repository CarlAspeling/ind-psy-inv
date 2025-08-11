<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'question_id' => 'required|integer|exists:questions,id',
                'response_option_id' => 'required|integer|exists:response_options,id',
                'questionnaire_attempt_id' => 'required|integer|exists:questionnaire_attempts,id'
            ]);

            // Get the attempt with relationships
            $attempt = \App\Models\QuestionnaireAttempt::with('questionnaire')->find($validated['questionnaire_attempt_id']);
            
            if (!$attempt) {
                return response()->json([
                    'success' => false, 
                    'error' => 'Assessment attempt not found'
                ], 404);
            }

            // Check if attempt has expired (24 hours)
            if ($attempt->started_at && $attempt->started_at->addHours(24)->isPast()) {
                return response()->json([
                    'success' => false, 
                    'error' => 'Assessment session has expired'
                ], 410);
            }

            // Verify the attempt is not completed
            if ($attempt->isCompleted()) {
                return response()->json([
                    'success' => false, 
                    'error' => 'Cannot modify responses for completed assessment'
                ], 422);
            }

            // Validate that the question belongs to the questionnaire
            $question = \App\Models\Question::find($validated['question_id']);
            if ($question->questionnaire_id !== $attempt->questionnaire_id) {
                return response()->json([
                    'success' => false, 
                    'error' => 'Question does not belong to this assessment'
                ], 422);
            }

            // Validate that the response option belongs to the question's response set
            $responseOption = \App\Models\ResponseOption::find($validated['response_option_id']);
            if ($responseOption->response_set_id !== $question->response_set_id) {
                return response()->json([
                    'success' => false, 
                    'error' => 'Invalid response option for this question'
                ], 422);
            }

            // Create or update response
            $response = Response::updateOrCreate(
                [
                    'question_id' => $validated['question_id'],
                    'questionnaire_attempt_id' => $validated['questionnaire_attempt_id'],
                ],
                [
                    'response_option_id' => $validated['response_option_id'],
                ]
            );

            // Calculate progress
            $totalQuestions = $attempt->questionnaire->questions()->count();
            $answeredQuestions = $attempt->responses()->count();
            $progressPercentage = round(($answeredQuestions / $totalQuestions) * 100);

            return response()->json([
                'success' => true, 
                'response_id' => $response->id,
                'attempt_id' => $attempt->id,
                'progress' => [
                    'answered' => $answeredQuestions,
                    'total' => $totalQuestions,
                    'percentage' => $progressPercentage
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid data provided',
                'details' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Failed to save response', [
                'request_data' => $request->all(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false, 
                'error' => 'Unable to save response. Please try again.'
            ], 500);
        }
    }
}
