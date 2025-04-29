<script setup>

import { ref, onMounted } from 'vue'
import axios from "axios";

import QuestionnaireIntro from "./QuestionnaireIntro.vue";
import QuestionnaireQuestion from "./QuestionnaireQuestion.vue";

const questionnaire = ref([]);
const questions = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get('/api/questionnaire')

        questionnaire.value = response.data.questionnaire
        questions.value = response.data.questions
    } catch (error) {
        console.error('Error fetching data:', error)
    }
})
</script>

<template>
    <div>
        <QuestionnaireIntro />
        <QuestionnaireQuestion />
        <div>{{ questionnaire.description }}</div>
        <div>
            <h3 class="mb-4 mt-6 font-bold">Question ...</h3>
            <p class="mb-2">This will be the question name. </p>
            <p>This will be the question options. </p>
        </div>
        <div>
            <h3 class="mb-4 mt-6 font-bold">Question 60</h3>
            <p class="mb-2">This will be the question name. </p>
            <p>This will be the question options. </p>
        </div>
        <div class="mt-6">
            <p>This is where the paginator will go, which will split the form into pages containing five questions. </p>
        </div>
    </div>
</template>

