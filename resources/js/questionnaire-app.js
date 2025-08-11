import { createApp } from 'vue';
import Questionnaire from './components/Questionnaire.vue';

// Wait for DOM and data to be ready
document.addEventListener('DOMContentLoaded', function() {
    // Get data passed from Blade template
    const initialData = window.questionnaireData;
    
    if (!initialData) {
        console.error('Questionnaire data not found');
        document.getElementById('questionnaire-app').innerHTML = `
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                <svg class="w-8 h-8 text-red-600 mx-auto mb-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <h3 class="text-red-800 font-semibold text-lg mb-2">Unable to Load Assessment</h3>
                <p class="text-red-700 mb-4">There was an error loading the questionnaire data.</p>
                <button onclick="window.location.reload()" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded transition duration-200">
                    Try Again
                </button>
            </div>
        `;
        return;
    }

    try {
        // Create Vue app
        const app = createApp(Questionnaire, {
            initialData: initialData
        });

        // Mount the app
        app.mount('#questionnaire-app');
    } catch (error) {
        console.error('Failed to mount Vue app:', error);
        document.getElementById('questionnaire-app').innerHTML = `
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                <svg class="w-8 h-8 text-yellow-600 mx-auto mb-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <h3 class="text-yellow-800 font-semibold text-lg mb-2">Interactive Features Unavailable</h3>
                <p class="text-yellow-700 mb-4">The enhanced questionnaire interface couldn't load, but you can still complete the assessment using the form above.</p>
                <p class="text-sm text-yellow-600">Please ensure JavaScript is enabled in your browser for the best experience.</p>
            </div>
        `;
    }
});