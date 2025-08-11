@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto text-center py-20">
    <div class="mb-8">
        <div class="w-16 h-16 mx-auto bg-yellow-100 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Assessment Session Expired</h1>
        <p class="text-lg text-gray-600 mb-8">
            Your assessment session has expired after 24 hours for security reasons.
        </p>
    </div>

    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold text-yellow-900 mb-3">Session Details:</h2>
        <div class="space-y-2 text-yellow-800 text-left">
            <p><strong>Session ID:</strong> {{ $attempt->session_id }}</p>
            <p><strong>Started:</strong> {{ $attempt->started_at->format('M j, Y g:i A') }}</p>
            <p><strong>Expired:</strong> {{ $attempt->started_at->addHours(24)->format('M j, Y g:i A') }}</p>
            @if($attempt->responses()->count() > 0)
                <p><strong>Progress:</strong> {{ $attempt->responses()->count() }} responses recorded</p>
            @endif
        </div>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold text-blue-900 mb-3">What happens next:</h2>
        <div class="space-y-2 text-blue-800">
            <p>• Your previous responses were not saved due to security policy</p>
            <p>• You can start a fresh assessment that will remain active for 24 hours</p>
            <p>• The new assessment will take approximately 10-15 minutes</p>
        </div>
    </div>

    <div class="space-y-4">
        <a href="{{ route('questionnaire.start', ['questionnaire' => 1]) }}" 
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-200">
            Start Fresh Assessment
        </a>
        
        <div>
            <a href="/" 
               class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded transition duration-200">
                Return Home
            </a>
        </div>
    </div>
</div>
@endsection