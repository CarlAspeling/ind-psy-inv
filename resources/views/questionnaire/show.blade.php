@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-10">
        
        <!-- Server-side Error Messages -->
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-8">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-red-800">Assessment Issue</h3>
                </div>
                <ul class="text-red-700 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
                <div class="mt-4">
                    <a href="/" class="inline-block bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded transition duration-200">
                        Start New Assessment
                    </a>
                </div>
            </div>
        @endif

        <!-- Server-side Success Messages -->
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

        <!-- Info Messages -->
        @if(session('info'))
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-blue-800">{{ session('info') }}</p>
                </div>
            </div>
        @endif

        <div id="questionnaire-app">
            <!-- Fallback content while Vue loads -->
            <div class="space-y-6">
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $questionnaire['name'] }}</h1>
                    <p class="text-gray-600 mb-6">{{ $questionnaire['description'] }}</p>
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center justify-center">
                            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600 mr-3"></div>
                            <p class="text-blue-800">Loading interactive questionnaire...</p>
                        </div>
                    </div>
                </div>
                
                <!-- Fallback form for no-JS users -->
                <noscript>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <p class="text-yellow-800">JavaScript is required for the interactive questionnaire. Please enable JavaScript or use a modern browser.</p>
                    </div>
                    
                    <!-- Simple non-JS form fallback -->
                    <form method="POST" action="{{ route('questionnaire.complete', $attempt) }}" class="space-y-8">
                        @csrf
                        @foreach($questions as $question)
                            <div class="p-6 border border-gray-200 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">
                                    {{ $question['question_text'] }}
                                </h3>
                                
                                @if(count($question['response_options']) > 0)
                                    <div class="space-y-3">
                                        @foreach($question['response_options'] as $option)
                                            <label class="flex items-center">
                                                <input 
                                                    type="radio" 
                                                    name="question_{{ $question['id'] }}" 
                                                    value="{{ $option['id'] }}"
                                                    class="mr-3"
                                                    required
                                                >
                                                <span>{{ $option['label'] }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        
                        <div class="text-center">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg">
                                Complete Learning Exercise
                            </button>
                        </div>
                    </form>
                </noscript>
            </div>
        </div>
    </div>

    <script>
        // Pass data to Vue app
        window.questionnaireData = {
            attempt: @json($attempt),
            questionnaire: @json($questionnaire),
            questions: @json($questions),
            existingResponses: @json($existingResponses),
            routes: {
                saveResponse: '{{ url("/api/save-response") }}',
                completeQuestionnaire: '{{ route("questionnaire.complete", $attempt) }}',
                showFeedback: '{{ route("feedback.show", $attempt) }}',
                startNew: '{{ route("questionnaire.start", ["questionnaire" => 1]) }}'
            },
            csrfToken: '{{ csrf_token() }}'
        };
    </script>

    @vite(['resources/js/questionnaire-app.js'])
@endsection