@extends('layouts.app')

@section('title', 'RIASEC Career Interest Assessment - Discover Your Career Path')

@section('content')
    <div class="max-w-4xl mx-auto">
        
        <!-- Error Messages -->
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-8">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-red-800">Unable to Start Assessment</h3>
                </div>
                <ul class="text-red-700 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Discover Your Career Interests
            </h1>
            <p class="text-xl text-gray-600 mb-6">
                Take the RIASEC Career Interest Inventory to understand your personality type and career preferences
            </p>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                <h2 class="text-lg font-semibold text-blue-900 mb-3">About the RIASEC Assessment</h2>
                <p class="text-blue-800 text-left">
                    The RIASEC model, developed by John Holland, categorizes career interests into six personality types:
                    <strong>Realistic</strong>, <strong>Investigative</strong>, <strong>Artistic</strong>, 
                    <strong>Social</strong>, <strong>Enterprising</strong>, and <strong>Conventional</strong>. 
                    This assessment will help you identify your top three personality types and provide 
                    personalized feedback about careers that match your interests.
                </p>
                
                <div class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                    <div class="bg-white p-3 rounded border">
                        <strong class="text-green-600">R</strong> - Realistic<br>
                        <span class="text-gray-600">Hands-on, practical work</span>
                    </div>
                    <div class="bg-white p-3 rounded border">
                        <strong class="text-blue-600">I</strong> - Investigative<br>
                        <span class="text-gray-600">Research, analysis, problem-solving</span>
                    </div>
                    <div class="bg-white p-3 rounded border">
                        <strong class="text-purple-600">A</strong> - Artistic<br>
                        <span class="text-gray-600">Creative, expressive work</span>
                    </div>
                    <div class="bg-white p-3 rounded border">
                        <strong class="text-red-600">S</strong> - Social<br>
                        <span class="text-gray-600">Helping, teaching, caring</span>
                    </div>
                    <div class="bg-white p-3 rounded border">
                        <strong class="text-yellow-600">E</strong> - Enterprising<br>
                        <span class="text-gray-600">Leading, persuading, selling</span>
                    </div>
                    <div class="bg-white p-3 rounded border">
                        <strong class="text-gray-600">C</strong> - Conventional<br>
                        <span class="text-gray-600">Organizing, detail-oriented work</span>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">What to Expect</h3>
                <div class="grid md:grid-cols-3 gap-4 text-sm text-left">
                    <div class="flex items-start">
                        <div class="bg-blue-100 rounded-full p-2 mr-3 mt-1">
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <strong>Questions:</strong><br>
                            Answer questions about your interests and preferences
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="bg-green-100 rounded-full p-2 mr-3 mt-1">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <strong>Time:</strong><br>
                            Takes approximately 10-15 minutes to complete
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="bg-purple-100 rounded-full p-2 mr-3 mt-1">
                            <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <strong>Results:</strong><br>
                            Get your 3-letter RIASEC code with personalized feedback
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <a href="{{ route('questionnaire.start', ['questionnaire' => 1]) }}" 
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg text-lg transition duration-200 shadow-lg hover:shadow-xl">
                    Start Assessment
                </a>
                
                @auth
                    <div class="mt-4">
                        <a href="{{ route('dashboard') }}" 
                           class="text-indigo-600 hover:text-indigo-800 font-medium">
                            View Your Assessment History →
                        </a>
                    </div>
                @else
                    <div class="mt-4">
                        <p class="text-sm text-gray-600 mb-2">
                            Want to save your results and track your progress?
                        </p>
                        <a href="{{ route('register') }}" 
                           class="text-indigo-600 hover:text-indigo-800 font-medium">
                            Create a free account →
                        </a>
                    </div>
                @endauth
                
                <p class="text-sm text-gray-500">
                    Your responses are automatically saved as you progress through the questionnaire
                </p>
            </div>
        </div>
    </div>
@endsection

