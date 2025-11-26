<template>
<form id="main-container" class="flex flex-col h-screen cursor-default-must" @submit.prevent="handleSubmit">

        <header id="header" class="px-6 py-4 border-b border-gray-800 section-clickable">
            <div class="flex items-center justify-between max-w-sm mx-auto">
                <button
                    class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-gray-700 transition-colors"
                    @click="$emit('close')"
                >
                    <Icon icon="mdi:close" class="text-white text-2xl" />
                </button>
                <div class="flex items-center space-x-3">
                    <div :style="{ backgroundColor: categoryColor }" class="w-8 h-8  rounded-lg flex items-center justify-center">
                        <i class="text-white text-sm" data-fa-i2svg=""><svg class="svg-inline--fa fa-shield-halved" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="shield-halved" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 0c4.6 0 9.2 1 13.4 2.9L457.7 82.8c22 9.3 38.4 31 38.3 57.2c-.5 99.2-41.3 280.7-213.6 363.2c-16.7 8-36.1 8-52.8 0C57.3 420.7 16.5 239.2 16 140c-.1-26.2 16.3-47.9 38.3-57.2L242.7 2.9C246.8 1 251.4 0 256 0zm0 66.8V444.8C394 378 431.1 230.1 432 141.4L256 66.8l0 0z"></path></svg></i>
                    </div>
                    <h1 class="text-lg font-bold text-white" >{{ getTextFromCategory(question.category) }}</h1>
                </div>
                <div class="text-right">
                    <div class="text-xs text-gray-400" >Points</div>
                    <div class="text-sm font-bold text-white" >+10</div>
                </div>
            </div>
        </header>


        <section id="quiz-content" class="flex-1 px-6 py-6 section-clickable">
            <div class="max-w-sm mx-auto">

                <div id="question-card" class="bg-gray-800 rounded-2xl p-6 mb-6 section-clickable">

                    <h2 class="text-xl font-bold text-white text-center" >
                        {{ question.question }}
                    </h2>

                </div>

                <div id="options-container" class="space-y-3 mb-6 section-clickable">

                    <label
                        v-for="answer in question.answers"
                        :key="answer.letter"
                        class="option-card flex items-center space-x-3 bg-gray-800 border-2 rounded-xl p-4 cursor-pointer transition-colors"
                        :style="{
                            borderColor: selectedAnswer === answer.letter ? categoryColor : '#374151',
                            '--hover-color': categoryColor + '80',
                        }"
                        @mouseenter="(e) => { if (selectedAnswer !== answer.letter) e.currentTarget.style.borderColor = categoryColor + '80'; }"
                        @mouseleave="(e) => { if (selectedAnswer !== answer.letter) e.currentTarget.style.borderColor = '#374151'; }"
                    >
                        <input type="radio" v-model="selectedAnswer" :value="answer.letter" name="answer" class="hidden">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center font-bold text-sm text-white" >
                                {{ answer.letter }}
                            </div>
                            <span class="text-white font-medium" >{{ answer.answer }}</span>
                        </div>
                    </label>




                </div>



            </div>
        </section>

        <footer id="footer" class="px-6 py-6 border-t border-gray-800 section-clickable">
            <div class="max-w-sm mx-auto">
                <button id="submit-btn" class="w-full bg-[#39B54A] hover:bg-[#39B54A]/80 text-white font-semibold py-4 px-6 rounded-xl transition-colors disabled:opacity-50 disabled:bg-gray-500/50 disabled:cursor-not-allowed section-clickable cursor-pointer" :disabled="selectedAnswer === null">
                    <div class="flex items-center justify-center space-x-2">
                       <Icon icon="mdi:send" class="text-white text-2xl" />
                        <span class="text-white" >Submit Answer</span>
                    </div>
                </button>

            </div>
        </footer>

    </form>
</template>

<script setup>

import { Icon } from '@iconify/vue';
import { categoriesColors } from '../utils/colors';
import { computed, ref } from 'vue';
import getTextFromCategory from '../utils/text';

const emit = defineEmits(['close', 'submit']);

const props = defineProps({
    question: {
        type: Object,
        required: true,
    },

});

const selectedAnswer = ref(null);

const categoryColor = computed(() => {
    return categoriesColors[props.question.category] || categoriesColors.password;
});

const handleSubmit = () => {
    emit('submit', selectedAnswer.value);
};

</script>
