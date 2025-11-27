<template>
    <form id="main-container" class="cursor-default-must flex min-h-dvh flex-col w-full" @submit.prevent="handleSubmit">
        <header id="header" class="section-clickable border-b border-gray-800 px-6 py-4">
            <div class="mx-auto flex max-w-lg items-center justify-between">
                <button
                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-800 transition-colors hover:bg-gray-700"
                    @click="$emit('close')"
                >
                    <Icon icon="mdi:close" class="text-2xl text-white" />
                </button>
                <div class="flex items-center space-x-3">
                    <div :style="{ backgroundColor: categoryColor }" class="flex h-8 w-8 items-center justify-center rounded-lg">
                        <i class="text-sm text-white" data-fa-i2svg=""
                            ><svg
                                class="svg-inline--fa fa-shield-halved"
                                aria-hidden="true"
                                focusable="false"
                                data-prefix="fas"
                                data-icon="shield-halved"
                                role="img"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512 512"
                                data-fa-i2svg=""
                            >
                                <path
                                    fill="currentColor"
                                    d="M256 0c4.6 0 9.2 1 13.4 2.9L457.7 82.8c22 9.3 38.4 31 38.3 57.2c-.5 99.2-41.3 280.7-213.6 363.2c-16.7 8-36.1 8-52.8 0C57.3 420.7 16.5 239.2 16 140c-.1-26.2 16.3-47.9 38.3-57.2L242.7 2.9C246.8 1 251.4 0 256 0zm0 66.8V444.8C394 378 431.1 230.1 432 141.4L256 66.8l0 0z"
                                ></path></svg
                        ></i>
                    </div>
                    <h1 class="text-lg font-bold text-white">{{ getTextFromCategory(question?.category) }}</h1>
                </div>
                <div class="text-right">
                    <div class="text-xs text-gray-400">Points</div>
                    <div class="text-sm font-bold text-white">{{ question?.points }}</div>
                </div>
            </div>
        </header>

        <section id="quiz-content" class="section-clickable flex-1 px-6 py-6">
            <div class="mx-auto max-w-lg">
                <div id="question-card" class="section-clickable mb-6 rounded-2xl bg-gray-800 p-6">
                    <h2 class="text-center text-xl font-bold text-white">
                        {{ question?.question }}
                    </h2>
                </div>

                <div id="options-container" class="section-clickable mb-6 space-y-3">
                    <label
                        v-for="answer in question?.answers || []"
                        :key="answer.letter"
                        class="option-card flex cursor-pointer items-center space-x-3 rounded-xl border-2 bg-gray-800 p-4 transition-colors"
                        :style="{
                            borderColor: selectedAnswer === answer.letter ? categoryColor : '#374151',
                            '--hover-color': categoryColor + '80',
                        }"
                        @mouseenter="
                            (e) => {
                                if (selectedAnswer !== answer.letter) e.currentTarget.style.borderColor = categoryColor + '80';
                            }
                        "
                        @mouseleave="
                            (e) => {
                                if (selectedAnswer !== answer.letter) e.currentTarget.style.borderColor = '#374151';
                            }
                        "
                    >
                        <input type="radio" v-model="selectedAnswer" :value="answer.letter" name="answer" class="hidden" />
                        <div class="flex items-center space-x-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-700 text-sm font-bold text-white">
                                {{ answer.letter }}
                            </div>
                            <span class="font-medium text-white">{{ answer.answer }}</span>
                        </div>
                    </label>
                </div>
            </div>
        </section>

        <footer id="footer" class="section-clickable border-t border-gray-800 px-6 py-6">
            <div class="mx-auto max-w-lg">
                <button
                    id="submit-btn"
                    class="section-clickable w-full cursor-pointer rounded-xl bg-[#39B54A] px-6 py-4 font-semibold text-white transition-colors hover:bg-[#39B54A]/80 disabled:cursor-not-allowed disabled:bg-gray-500/50 disabled:opacity-50"
                    :disabled="selectedAnswer === null"
                >
                    <div class="flex items-center justify-center space-x-2">
                        <Icon icon="mdi:send" class="text-2xl text-white" />
                        <span class="text-white">Submit Answer</span>
                    </div>
                </button>
            </div>
        </footer>
    </form>
</template>

<script setup>
import { Icon } from '@iconify/vue';
import { computed, ref } from 'vue';
import { categoriesColors } from '../utils/colors';
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
    return categoriesColors[props.question?.category] || categoriesColors.password;
});

const handleSubmit = () => {
    emit('submit', selectedAnswer.value);
};
</script>
