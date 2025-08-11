@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto text-center py-20">
    <div class="mb-8">
        <div class="text-6xl font-bold text-red-600 mb-4">500</div>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Server Error</h1>
        <p class="text-lg text-gray-600 mb-8">
            Something went wrong on our end. We're working to fix this issue.
        </p>
    </div>

    <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold text-red-900 mb-3">What happened:</h2>
        <div class="space-y-2 text-red-800">
            <p>• A technical error occurred while processing your request</p>
            <p>• Your assessment progress has been automatically saved</p>
            <p>• You can try again in a few moments</p>
        </div>
    </div>

    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-8">
        <p class="text-sm text-yellow-800">
            <strong>Technical Details:</strong> If this error persists, please note the time it occurred and try refreshing the page.
        </p>
    </div>

    <div class="space-y-4">
        <button onclick="window.location.reload()" 
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 mr-4">
            Try Again
        </button>
        <a href="/" 
           class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-lg transition duration-200">
            Go Home
        </a>
    </div>
</div>
@endsection