<script setup>
const props = defineProps({
    questionnaire: {
        type: Object,
        required: true
    },
    attempt: {
        type: Object,
        required: true
    }
})
</script>

<template>
    <div class="text-center bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-bold text-blue-900 mb-3">{{ questionnaire.name }}</h2>
        <p class="text-blue-800 mb-4">{{ questionnaire.description }}</p>
        
        <div class="grid md:grid-cols-3 gap-4 text-sm">
            <div class="bg-white p-3 rounded border">
                <div class="font-semibold text-gray-900">Questions</div>
                <div class="text-gray-600">{{ questionnaire.questions?.length || 0 }} total</div>
            </div>
            <div class="bg-white p-3 rounded border">
                <div class="font-semibold text-gray-900">Session ID</div>
                <div class="text-gray-600 text-xs">{{ attempt.session_id?.substring(0, 8) }}...</div>
            </div>
            <div class="bg-white p-3 rounded border">
                <div class="font-semibold text-gray-900">Started</div>
                <div class="text-gray-600">{{ new Date(attempt.started_at).toLocaleTimeString() }}</div>
            </div>
        </div>

        <div class="mt-4 p-3 bg-blue-100 rounded text-sm text-blue-800">
            <p><strong>Instructions:</strong> Answer each question based on your genuine interests and preferences. Your responses are automatically saved as you progress through the assessment.</p>
        </div>
    </div>
</template>

