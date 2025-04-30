<script setup>
import { ref, onMounted } from 'vue'

const questionnaire = ref({})
const question = ref({})
const loading = ref(true)

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
</script>

<template>
    <div>{{ questionnaire.name }}</div>
    <div>{{ questionnaire.description }}</div>
    <br>
    <div>
        <p>Questions</p>
        <ul>
            <li v-for="q in questionnaire.questions" :key="q.id">{{ q.question_text }}</li>
        </ul>
    </div>
</template>
