<?php

namespace App\Http\Controllers;

use App\Services\ResultsService;
use Illuminate\Http\Request;
use App\Models\QuestionnaireAttempt;
use App\Models\TraitFeedbackTemplate;

class FeedbackController extends Controller
{
    public function show(QuestionnaireAttempt $attempt)
    {
        try {
            // Validate attempt exists and is accessible
            if (!$attempt || !$attempt->questionnaire) {
                abort(404, 'Assessment attempt not found.');
            }

            // If user is authenticated, ensure they own this attempt or it's a guest attempt
            if (auth()->check() && $attempt->user_id !== null && $attempt->user_id !== auth()->id()) {
                abort(403, 'You do not have permission to access this assessment.');
            }

            // Check if attempt is completed
            if (!$attempt->isCompleted()) {
                return redirect()->route('questionnaire.attempt', $attempt)
                    ->withErrors([
                        'incomplete' => 'Please complete the assessment before viewing feedback.'
                    ]);
            }

            // Check if attempt has sufficient responses
            $totalQuestions = $attempt->questionnaire->questions()->count();
            $answeredQuestions = $attempt->responses()->count();
            
            if ($answeredQuestions < $totalQuestions) {
                return redirect()->route('questionnaire.attempt', $attempt)
                    ->withErrors([
                        'insufficient' => 'Assessment appears to be incomplete. Please answer all questions.'
                    ]);
            }

            // Calculate results
            $results = app(ResultsService::class)->calculateResults($attempt);

            if (!$results || !isset($results['three_letter_code'])) {
                \Log::error('Failed to calculate results for attempt', [
                    'attempt_id' => $attempt->id,
                    'results' => $results
                ]);
                
                return redirect('/')->withErrors([
                    'calculation' => 'Unable to calculate your results. Please contact support.'
                ]);
            }

            $code = $results['three_letter_code'];

            // Validate code format
            if (strlen($code) !== 3 || !ctype_alpha($code)) {
                \Log::error('Invalid RIASEC code generated', [
                    'attempt_id' => $attempt->id,
                    'code' => $code
                ]);
                
                return redirect('/')->withErrors([
                    'code' => 'Invalid results generated. Please try taking the assessment again.'
                ]);
            }

            $letters = str_split($code);

            $feedback = collect($letters)->mapWithKeys(function ($letter, $index) use ($attempt) {
                $role = match ($index) {
                    0 => 'primary',
                    1 => 'supporting',
                    2 => 'modulating',
                    default => 'unknown'
                };

                $template = TraitFeedbackTemplate::whereHas('domain', fn($q) => $q->where('code', $letter))
                    ->where('role', $role)
                    ->first();

                if (!$template) {
                    \Log::warning('Missing feedback template', [
                        'attempt_id' => $attempt->id,
                        'letter' => $letter,
                        'role' => $role
                    ]);
                }

                return [$role => $template];
            });

            // Check if we have all required feedback templates
            $missingFeedback = $feedback->filter(fn($template) => is_null($template));
            if ($missingFeedback->count() > 0) {
                \Log::error('Missing feedback templates for attempt', [
                    'attempt_id' => $attempt->id,
                    'code' => $code,
                    'missing_roles' => $missingFeedback->keys()->toArray()
                ]);
                
                // Still show results but with a warning
                session()->flash('warning', 'Some feedback content is temporarily unavailable, but your RIASEC code is valid.');
            }

            return view('feedback.show', [
                'attempt' => $attempt,
                'code' => $code,
                'feedback' => $feedback,
                'results' => $results,
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to show feedback', [
                'attempt_id' => $attempt->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect('/')->withErrors([
                'system' => 'Unable to display your results. Please contact support or try taking the assessment again.'
            ]);
        }
    }
}
