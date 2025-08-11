@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-20">
    <div class="bg-red-50 border border-red-200 rounded-lg p-8">
        <div class="flex items-center mb-4">
            <div class="flex-shrink-0">
                <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h1 class="text-xl font-semibold text-red-800">Validation Error</h1>
            </div>
        </div>

        <div class="text-red-700 mb-6">
            <p class="mb-4">There were some issues with your submission:</p>
            
            @if($errors->any())
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @else
                <p>Please check your input and try again.</p>
            @endif
        </div>

        <div class="flex space-x-4">
            <button onclick="history.back()" 
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded transition duration-200">
                Go Back
            </button>
            <a href="/" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded transition duration-200">
                Start Over
            </a>
        </div>
    </div>
</div>
@endsection