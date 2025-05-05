<script setup>
import { ref, computed, onMounted } from 'vue'

const questionnaire = ref({})
const currentPage = ref(1)
const perPage = 3
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
    <div v-else>
        <h2>{{ questionnaire.name }}</h2>
        <p>{{ questionnaire.description }}</p>

        <div v-for="question in paginatedQuestions" :key="question.id" class="question">
            <p>{{ question.question_text }}</p>
            <div v-for="option in question.response_options" :key="option.id">
                <label>
                    <input
                        type="radio"
                        :name="'question-' + question.id"
                        :value="option.id"
                        v-model="responses[question.id]"
                        @change="saveResponse(question.id, option.id)"
                    />
                    {{ option.label }}
                </label>
            </div>
        </div>

        <div class="pagination">
            <button @click="currentPage--" :disabled="currentPage === 1">Previous</button>
            <span>Page {{ currentPage }} of {{ totalPages }}</span>
            <button @click="currentPage++" :disabled="currentPage === totalPages">Next</button>
        </div>
    </div>
</template>

<style scoped>
.question {
    margin-top: 2rem;
    margin-bottom: 2rem;
}
.pagination {
    margin-top: 2rem;
    display: flex;
    gap: 1rem;
    align-items: center;
}
</style>
