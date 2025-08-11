<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use App\Models\QuestionnaireAttempt;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QuestionnaireAttemptController extends Controller
{
    /**
     * Start a new questionnaire attempt
     */
    public function start(Questionnaire $questionnaire): RedirectResponse
    {
        try {
            // Check if questionnaire has questions
            if ($questionnaire->questions()->count() === 0) {
                return redirect('/')->withErrors([
                    'questionnaire' => 'This questionnaire is not available or has no questions.'
                ]);
            }

            $attempt = QuestionnaireAttempt::create([
                'questionnaire_id' => $questionnaire->id,
                'user_id' => auth()->id(), // Link to authenticated user (nullable for guests)
            ]);

            return redirect()->route('questionnaire.attempt', $attempt);

        } catch (\Exception $e) {
            \Log::error('Failed to start questionnaire attempt', [
                'questionnaire_id' => $questionnaire->id,
                'error' => $e->getMessage()
            ]);

            return redirect('/')->withErrors([
                'system' => 'Unable to start the assessment. Please try again.'
            ]);
        }
    }

    /**
     * Show the questionnaire attempt form
     */
    public function show(QuestionnaireAttempt $attempt): View
    {
        try {
            // Check if attempt is accessible
            if (!$attempt || !$attempt->questionnaire) {
                abort(404, 'Assessment attempt not found.');
            }

            // If user is authenticated, ensure they own this attempt or it's a guest attempt
            if (auth()->check() && $attempt->user_id !== null && $attempt->user_id !== auth()->id()) {
                abort(403, 'You do not have permission to access this assessment.');
            }

            // Check if attempt has expired (24 hours)
            if ($attempt->started_at && $attempt->started_at->addHours(24)->isPast()) {
                return view('errors.expired-attempt', ['attempt' => $attempt]);
            }

            $questionnaire = $attempt->questionnaire->load([
                'questions.responseSet.responseOptions'
            ]);

            // Validate questionnaire has questions
            if ($questionnaire->questions->isEmpty()) {
                return redirect('/')->withErrors([
                    'questionnaire' => 'This assessment is currently unavailable.'
                ]);
            }

            $questions = $questionnaire->questions->map(function ($question) {
                $responseOptions = $question->responseSet
                    ? $question->responseSet->responseOptions->sortBy('order')->values()->map(function ($option) {
                        return [
                            'id' => $option->id,
                            'label' => $option->label,
                            'value' => $option->value,
                        ];
                    })->values()->toArray()
                    : [];

                // Validate that question has response options
                if (empty($responseOptions)) {
                    \Log::warning('Question without response options', ['question_id' => $question->id]);
                }

                return [
                    'id' => $question->id,
                    'question_text' => $question->question_text,
                    'response_options' => $responseOptions,
                ];
            });

            // Get existing responses for this attempt
            $existingResponses = $attempt->responses()
                ->with('responseOption')
                ->get()
                ->keyBy('question_id');

            // Create a questionnaire object with transformed questions
            $questionnaireData = [
                'id' => $questionnaire->id,
                'name' => $questionnaire->name,
                'description' => $questionnaire->description,
                'questions' => $questions->toArray()
            ];

            return view('questionnaire.show', [
                'attempt' => $attempt,
                'questionnaire' => $questionnaireData,
                'questions' => $questions,
                'existingResponses' => $existingResponses,
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to load questionnaire attempt', [
                'attempt_id' => $attempt->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect('/')->withErrors([
                'system' => 'Unable to load the assessment. Please try starting a new one.'
            ]);
        }
    }

    /**
     * Mark an attempt as completed and redirect to feedback
     */
    public function complete(Request $request, QuestionnaireAttempt $attempt): RedirectResponse
    {
        try {
            // Validate attempt exists and is accessible
            if (!$attempt || !$attempt->questionnaire) {
                return redirect('/')->withErrors([
                    'attempt' => 'Assessment attempt not found.'
                ]);
            }

            // If user is authenticated, ensure they own this attempt or it's a guest attempt
            if (auth()->check() && $attempt->user_id !== null && $attempt->user_id !== auth()->id()) {
                return redirect('/')->withErrors([
                    'permission' => 'You do not have permission to access this assessment.'
                ]);
            }

            // Check if attempt has expired
            if ($attempt->started_at && $attempt->started_at->addHours(24)->isPast()) {
                return redirect()->route('questionnaire.start', ['questionnaire' => $attempt->questionnaire_id])
                    ->withErrors(['expired' => 'Your assessment session has expired. Please start a new one.']);
            }

            // Check if already completed
            if ($attempt->isCompleted()) {
                return redirect()->route('feedback.show', $attempt)
                    ->with('info', 'This assessment was already completed.');
            }

            // Handle no-JS form submission (fallback)
            if ($request->isMethod('POST') && !$request->ajax()) {
                $this->handleFormSubmission($request, $attempt);
            }

            // Validate all questions have been answered
            $totalQuestions = $attempt->questionnaire->questions()->count();
            $answeredQuestions = $attempt->responses()->count();

            if ($answeredQuestions < $totalQuestions) {
                return redirect()->route('questionnaire.attempt', $attempt)
                    ->withErrors([
                        'incomplete' => "Please answer all questions before completing the assessment. ({$answeredQuestions}/{$totalQuestions} completed)"
                    ]);
            }

            // Mark as completed
            $attempt->markCompleted();

            // Redirect to feedback with success message
            return redirect()->route('feedback.show', $attempt)
                ->with('success', 'Assessment completed successfully! Here are your results.');

        } catch (\Exception $e) {
            \Log::error('Failed to complete questionnaire attempt', [
                'attempt_id' => $attempt->id ?? null,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('questionnaire.attempt', $attempt)
                ->withErrors([
                    'system' => 'Unable to complete the assessment. Please try again.'
                ]);
        }
    }

    /**
     * Handle form submission for no-JS users
     */
    private function handleFormSubmission(Request $request, QuestionnaireAttempt $attempt): void
    {
        $questions = $attempt->questionnaire->questions;

        foreach ($questions as $question) {
            $responseOptionId = $request->input("question_{$question->id}");

            if ($responseOptionId) {
                Response::updateOrCreate(
                    [
                        'question_id' => $question->id,
                        'questionnaire_attempt_id' => $attempt->id,
                    ],
                    [
                        'response_option_id' => $responseOptionId,
                    ]
                );
            }
        }
    }
}
