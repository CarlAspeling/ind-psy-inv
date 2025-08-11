<?php

namespace App\Http\Controllers;

use App\Services\ResultsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{

    /**
     * Show the user dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();
        
        // Get user's questionnaire attempts with related data
        $attempts = $user->questionnaireAttempts()
            ->with(['questionnaire', 'responses'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate results for completed attempts
        $resultsService = new ResultsService();
        $attemptsWithResults = $attempts->getCollection()->map(function ($attempt) use ($resultsService) {
            $attempt->results = null;
            if ($attempt->isCompleted() && $attempt->responses->isNotEmpty()) {
                try {
                    $attempt->results = $resultsService->calculateResults($attempt);
                } catch (\Exception $e) {
                    // Results calculation failed, will show without results
                }
            }
            return $attempt;
        });

        $attempts->setCollection($attemptsWithResults);

        return view('dashboard', compact('user', 'attempts'));
    }
}
