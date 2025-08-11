@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto text-center py-20">
    <div class="mb-8">
        <div class="text-6xl font-bold text-blue-600 mb-4">404</div>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Page Not Found</h1>
        <p class="text-lg text-gray-600 mb-8">
            The page you're looking for doesn't exist or may have been moved.
        </p>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold text-blue-900 mb-3">What you can do:</h2>
        <div class="space-y-2 text-blue-800">
            <p>• Check the URL for typos</p>
            <p>• Return to the homepage and start a new assessment</p>
            <p>• If you were taking an assessment, your progress may have been saved</p>
        </div>
    </div>

    <div class="space-y-4">
        <a href="{{ route('questionnaire.start', ['questionnaire' => 1]) }}" 
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 mr-4">
            Start New Assessment
        </a>
        <a href="/" 
           class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-lg transition duration-200">
            Go Home
        </a>
    </div>
</div>
@endsection