<script setup>
import { ref, computed, onMounted, nextTick } from 'vue'
import QuestionnaireIntro from './QuestionnaireIntro.vue'
import QuestionnaireQuestion from './QuestionnaireQuestion.vue'

const props = defineProps({
    initialData: {
        type: Object,
        required: true
    }
})

const questionnaire = ref({})
const attempt = ref({})
const currentPage = ref(1)
const perPage = 5
const loading = ref(true)
const responses = ref({})
const saving = ref(false)
const error = ref('')
const completed = ref(false)

const totalPages = computed(() => {
    return Math.ceil((questionnaire.value.questions?.length || 0) / perPage)
})

const paginatedQuestions = computed(() => {
    const start = (currentPage.value - 1) * perPage
    const end = start + perPage
    return questionnaire.value.questions?.slice(start, end) || []
})

const allQuestionsAnswered = computed(() => {
    const totalQuestions = questionnaire.value.questions?.length || 0
    const answeredCount = Object.keys(responses.value).length
    return answeredCount >= totalQuestions
})

const progressPercentage = computed(() => {
    const totalQuestions = questionnaire.value.questions?.length || 0
    if (totalQuestions === 0) return 0
    const answeredCount = Object.keys(responses.value).length
    return Math.round((answeredCount / totalQuestions) * 100)
})

onMounted(async () => {
    try {
        // Use data passed from Blade template
        const data = props.initialData
        questionnaire.value = data.questionnaire
        attempt.value = data.attempt
        completed.value = data.attempt.completed_at !== null

        // Load existing responses
        if (data.existingResponses) {
            Object.keys(data.existingResponses).forEach(questionId => {
                responses.value[questionId] = data.existingResponses[questionId].response_option_id
            })
        }
    } catch (error) {
        console.error('Failed to initialize questionnaire:', error)
        error.value = 'Failed to load questionnaire. Please refresh the page.'
    } finally {
        loading.value = false
    }
})

const saveResponse = async (questionId, responseOptionId) => {
    if (completed.value) return // Prevent changes to completed questionnaire
    
    saving.value = true
    error.value = ''

    try {
        const response = await fetch(props.initialData.routes.saveResponse, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': props.initialData.csrfToken
            },
            body: JSON.stringify({
                question_id: questionId,
                response_option_id: responseOptionId,
                questionnaire_attempt_id: attempt.value.id
            })
        })

        const result = await response.json()
        
        if (!result.success) {
            // Handle specific error types
            if (response.status === 410) {
                // Session expired
                error.value = 'Your learning session has expired. Redirecting to start a new one...'
                setTimeout(() => {
                    window.location.href = props.initialData.routes.startNew || '/'
                }, 3000)
                return
            } else if (response.status === 422) {
                // Validation or business logic error
                error.value = result.error || 'Unable to save this response. Please check your selection.'
            } else {
                throw new Error(result.error || 'Failed to save response')
            }
            return
        }

        // Update local responses
        responses.value[questionId] = responseOptionId
        
        // Update progress if provided
        if (result.progress) {
            // Could emit this to update parent component if needed
            console.log('Progress:', result.progress)
        }
        
    } catch (err) {
        console.error('Failed to save response:', err)
        
        if (err.name === 'TypeError' && err.message.includes('fetch')) {
            error.value = 'Connection error. Please check your internet connection and try again.'
        } else {
            error.value = 'Failed to save your response. Please try again.'
        }
    } finally {
        saving.value = false
    }
}

const completeQuestionnaire = async () => {
    if (!allQuestionsAnswered.value || completed.value) return

    // Double-check all questions are answered
    const totalQuestions = questionnaire.value.questions?.length || 0
    const answeredCount = Object.keys(responses.value).length
    
    if (answeredCount < totalQuestions) {
        error.value = `Please answer all questions before completing (${answeredCount}/${totalQuestions} answered)`
        return
    }

    saving.value = true
    error.value = ''

    try {
        // Show loading message
        const loadingMessage = 'Completing learning exercise and calculating your results...'
        
        // Create form with loading indicator
        const overlay = document.createElement('div')
        overlay.className = 'fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50'
        overlay.innerHTML = `
            <div class="bg-white rounded-lg p-8 max-w-md mx-4 text-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Processing Results</h3>
                <p class="text-gray-600">${loadingMessage}</p>
            </div>
        `
        document.body.appendChild(overlay)

        // Submit form to complete questionnaire
        const form = document.createElement('form')
        form.method = 'POST'
        form.action = props.initialData.routes.completeQuestionnaire
        
        const csrfInput = document.createElement('input')
        csrfInput.type = 'hidden'
        csrfInput.name = '_token'
        csrfInput.value = props.initialData.csrfToken
        form.appendChild(csrfInput)
        
        document.body.appendChild(form)
        form.submit()
        
    } catch (err) {
        console.error('Failed to complete questionnaire:', err)
        error.value = 'Failed to complete the learning exercise. Please try again.'
        saving.value = false
        
        // Remove loading overlay if it exists
        const overlay = document.querySelector('.fixed.inset-0.bg-gray-900')
        if (overlay) {
            overlay.remove()
        }
    }
}

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++
        nextTick(() => {
            window.scrollTo({ top: 0, behavior: 'smooth' })
        })
    }
}

const previousPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--
        nextTick(() => {
            window.scrollTo({ top: 0, behavior: 'smooth' })
        })
    }
}
</script>

<template>
    <!-- Loading State -->
    <div v-if="loading" class="flex items-center justify-center py-20">
        <div class="text-center">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto mb-4"></div>
            <p class="text-gray-600">Loading questionnaire...</p>
        </div>
    </div>

    <!-- Completed State -->
    <div v-else-if="completed" class="text-center py-10">
        <div class="bg-green-50 border border-green-200 rounded-lg p-8 mb-6">
            <div class="flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-green-800 mb-2">Learning Exercise Completed!</h2>
            <p class="text-green-700 mb-6">Thank you for completing the RIASEC interest exploration tool.</p>
            <a :href="initialData.routes.showFeedback" 
               class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                View Your Results
            </a>
        </div>
    </div>

    <!-- Main Questionnaire -->
    <div v-else class="space-y-6">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ questionnaire.name }}</h1>
            <p class="text-gray-600 mb-4">{{ questionnaire.description }}</p>
            
            <!-- Progress Bar -->
            <div class="max-w-md mx-auto">
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Progress</span>
                    <span>{{ Object.keys(responses).length }} / {{ questionnaire.questions?.length || 0 }} questions</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                         :style="{ width: progressPercentage + '%' }"></div>
                </div>
                <p class="text-sm text-gray-500 mt-2">{{ progressPercentage }}% complete</p>
            </div>

        </div>

        <!-- Error Message -->
        <div v-if="error" class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-red-800">{{ error }}</p>
            </div>
        </div>

        <!-- Questions -->
        <div class="space-y-8">
            <QuestionnaireQuestion
                v-for="(question, index) in paginatedQuestions"
                :key="question.id"
                :question="question"
                :questionNumber="(currentPage - 1) * perPage + index + 1"
                :selectedValue="responses[question.id]"
                :disabled="saving || completed"
                @response-selected="saveResponse"
                :class="index % 2 === 0 ? 'bg-gray-50' : 'bg-white'"
            />
        </div>

        <!-- Navigation -->
        <div class="flex items-center justify-between pt-8 border-t">
            <!-- Previous Button -->
            <button 
                v-if="currentPage > 1"
                @click="previousPage"
                :disabled="saving"
                class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Previous
            </button>
            <div v-else></div>

            <!-- Page Info -->
            <span class="text-sm text-gray-600">
                Page {{ currentPage }} of {{ totalPages }}
            </span>

            <!-- Next Button -->
            <button 
                v-if="currentPage < totalPages"
                @click="nextPage"
                :disabled="saving"
                class="flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                Next
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
            <div v-else></div>
        </div>

        <!-- Complete Button -->
        <div v-if="currentPage === totalPages" class="text-center pt-6">
            <button 
                @click="completeQuestionnaire"
                :disabled="!allQuestionsAnswered || saving"
                :class="[
                    'px-8 py-3 rounded-lg font-semibold text-lg transition duration-200',
                    allQuestionsAnswered && !saving 
                        ? 'bg-green-600 hover:bg-green-700 text-white shadow-lg hover:shadow-xl' 
                        : 'bg-gray-300 text-gray-500 cursor-not-allowed'
                ]">
                <span v-if="saving" class="flex items-center justify-center">
                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></div>
                    Completing...
                </span>
                <span v-else>Complete Learning Exercise</span>
            </button>
            
            <p v-if="!allQuestionsAnswered" class="text-sm text-gray-500 mt-2">
                Please answer all questions to complete the learning exercise
            </p>
        </div>
    </div>
</template>

