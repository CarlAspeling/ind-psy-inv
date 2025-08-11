<script setup>
const props = defineProps({
    question: {
        type: Object,
        required: true
    },
    questionNumber: {
        type: Number,
        required: true
    },
    selectedValue: {
        type: [String, Number],
        default: null
    },
    disabled: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['response-selected'])

const handleResponseChange = (responseOptionId) => {
    if (!props.disabled) {
        emit('response-selected', props.question.id, responseOptionId)
    }
}
</script>

<template>
    <div class="p-6 border border-gray-200 rounded-lg shadow-sm">
        <div class="mb-6">
            <div class="flex items-start mb-3">
                <span class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-semibold mr-3">
                    {{ questionNumber }}
                </span>
                <h3 class="text-lg font-medium text-gray-900 leading-tight">
                    {{ question.question_text }}
                </h3>
            </div>
        </div>

        <div v-if="question.response_options && question.response_options.length > 0" class="space-y-3">
            <label 
                v-for="option in question.response_options" 
                :key="option.id"
                :class="[
                    'flex items-center p-3 border rounded-lg cursor-pointer transition duration-200 hover:bg-gray-50',
                    selectedValue == option.id 
                        ? 'border-blue-500 bg-blue-50' 
                        : 'border-gray-200',
                    disabled ? 'cursor-not-allowed opacity-60' : ''
                ]"
            >
                <input
                    type="radio"
                    :name="`question-${question.id}`"
                    :value="option.id"
                    :checked="selectedValue == option.id"
                    :disabled="disabled"
                    @change="handleResponseChange(option.id)"
                    class="mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 disabled:opacity-60"
                />
                <span class="text-gray-700 flex-1">{{ option.label }}</span>
            </label>
        </div>

        <div v-else class="text-gray-500 italic">
            No response options available for this question.
        </div>
    </div>
</template>
