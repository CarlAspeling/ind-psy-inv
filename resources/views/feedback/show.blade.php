@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto py-10">
        
        <!-- Success Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-8">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif
        <h1 class="text-2xl font-bold mb-4">Your Career Interest Feedback</h1>

        <p class="mb-6">Based on your results, your code is: <strong>{{ $code }}</strong></p>

        @foreach(['primary', 'supporting', 'modulating'] as $role)
            @php $template = $feedback[$role] ?? null; @endphp

            @if ($template)
                <div class="mb-6 p-4 border rounded-lg">
                    <h2 class="text-xl font-semibold capitalize">{{ $role }} trait ({{ $template->domain->name }})</h2>
                    <p class="mt-2 text-gray-700">{{ $template->description }}</p>
                </div>
            @endif
        @endforeach

        <!-- Action buttons -->
        <div class="mt-8 text-center border-t pt-6">
            <p class="text-sm text-gray-600 mb-4">
                Assessment completed on {{ $attempt->completed_at->format('M j, Y g:i A') }}
            </p>
            
            <div class="space-x-4">
                <a href="{{ route('questionnaire.start', ['questionnaire' => 1]) }}" 
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                    Take Assessment Again
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" 
                       class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-6 rounded-lg transition duration-200">
                        Return to Dashboard
                    </a>
                @else
                    <a href="/" 
                       class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-6 rounded-lg transition duration-200">
                        Return Home
                    </a>
                @endauth
            </div>
            
            <p class="text-xs text-gray-500 mt-4">
                Your results are based on the RIASEC model developed by John Holland
            </p>
        </div>
    </div>
@endsection
