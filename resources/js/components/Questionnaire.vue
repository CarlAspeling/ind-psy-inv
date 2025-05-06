<script setup>
import { ref, computed, onMounted } from 'vue'

const questionnaire = ref({})
const currentPage = ref(1)
const perPage = 5
const loading = ref(true)
const responses = ref({})

const totalPages = computed(() => {
    return Math.ceil((questionnaire.value.questions?.length || 0) / perPage)
})

const paginatedQuestions = computed(() => {
    const start = (currentPage.value - 1) * perPage
    const end = start + perPage
    return questionnaire.value.questions?.slice(start, end) || []
})

onMounted(async () => {
    try {
        const res = await fetch('/api/questionnaire')
        questionnaire.value = await res.json()
    } catch (error) {
        console.error('Failed to fetch questionnaire:', error)
    } finally {
        loading.value = false
    }
})

const saveResponse = async (questionId, responseOptionId) => {
    try {
        await fetch('/api/save-response', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                question_id: questionId,
                response_option_id: responseOptionId,
                questionnaire_attempt_id: 1 // currently static, need to make dynamic down the line
            })
        })
    } catch (err) {
        console.error('Failed to save response:', err)
    }
}
</script>

<template>
    <div v-if="loading">Loading...</div>
    <div v-else class="flex flex-col">
        <h2 class="text-xl flex font-bold mb-2 justify-center">{{ questionnaire.name }}</h2>
        <p class="mb-4 flex justify-center italic">{{ questionnaire.description }}</p>

        <div class="flex-1 overflow-auto">
            <div v-for="(question, index) in paginatedQuestions" :key="question.id" :class="['mb-12 p-1 rounded-lg', index % 2 === 0 ? 'bg-gray-100' : 'bg-white']">
                <p class="pt-4 mb-4 underline flex justify-center">{{ question.question_text }}</p>

                <div class="flex justify-between gap-4 w-full">
                    <label
                        v-for="option in question.response_options"
                        :key="option.id"
                        class="flex-1 flex flex-col items-center text-center"
                    >
                        <input
                            type="radio"
                            :name="'question-' + question.id"
                            :value="option.id"
                            v-model="responses[question.id]"
                            @change="saveResponse(question.id, option.id)"
                            class="mb-2"
                        />
                        <span>{{ option.label }}</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-4 justify-center">
            <button v-show="currentPage > 1" @click="currentPage--">Previous</button>
            <span>Page {{ currentPage }} of {{ totalPages }}</span>
            <button v-show="currentPage < totalPages" @click="currentPage++">Next</button>
        </div>

    </div>
</template>

