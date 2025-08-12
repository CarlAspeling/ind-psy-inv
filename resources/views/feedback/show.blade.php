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
        <!-- DISCLAIMER -->
        <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-4 mb-6">
            <h2 class="text-lg font-semibold text-yellow-900 mb-2">⚠️ Educational Results Only</h2>
            <p class="text-yellow-800 text-sm">
                <strong>These results are for educational purposes only.</strong> This is not professional career counseling, 
                psychological assessment, or diagnostic evaluation. Do not make important life decisions based on these results. 
                Consult qualified professionals for career guidance.
            </p>
        </div>
        
        <h1 class="text-2xl font-bold mb-4">Your Learning Results</h1>

        <p class="mb-6">Based on your responses, your educational code is: <strong>{{ $code }}</strong></p>

        @foreach(['primary', 'supporting', 'modulating'] as $role)
            @php $template = $feedback[$role] ?? null; @endphp

            @if ($template)
                <div class="mb-6 p-4 border rounded-lg">
                    <h2 class="text-xl font-semibold capitalize">{{ $role }} interest type ({{ $template->domain->name }})</h2>
                    <p class="mt-2 text-gray-700">{{ $template->description }}</p>
                    <p class="mt-2 text-xs text-gray-500 italic">Educational information only - not professional assessment</p>
                </div>
            @endif
        @endforeach

        <!-- Action buttons -->
        <div class="mt-8 text-center border-t pt-6">
            <p class="text-sm text-gray-600 mb-4">
                Learning exercise completed on {{ $attempt->completed_at->format('M j, Y g:i A') }}
            </p>
            
            <div class="space-x-4">
                <a href="{{ route('questionnaire.start', ['questionnaire' => 1]) }}" 
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                    Try Learning Tool Again
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
                This educational exercise is based on the RIASEC model developed by John Holland. 
                For educational purposes only - not professional assessment.
            </p>
        </div>
    </div>
@endsection
