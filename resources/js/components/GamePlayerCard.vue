<template>
    <div
        :class="id === playerId ? 'border-2 border-green-500/95 bg-gradient-to-r from-green-500/15 to-green-600/5' : 'bg-gray-700'"
        class="flex items-center justify-between rounded-lg p-3"
    >
        <div class="flex items-center space-x-3">
            <h2 class="text-sm font-bold text-white">#{{ order }}</h2>
            <div :class="`h-8 w-8 bg-${color}-500 flex items-center justify-center rounded-full`">
                <span class="text-sm font-bold text-white">{{ username.charAt(0).toUpperCase() }}</span>
            </div>
            <span class="font-medium text-gray-300">{{ username }}</span>
            <span v-if="id === playerId" class="rounded-full bg-[#39b54a] px-2 py-0.5 text-xs text-white">Current</span>
        </div>
        <div class="flex items-center space-x-2 text-right">
            <div>
                <div class="text-xs text-gray-400">Position</div>
                <div class="text-sm font-bold text-white">{{ position }}</div>
            </div>
            <div>
                <div class="text-xs text-gray-400">Score</div>
                <div class="text-sm font-bold text-white">{{ score }}</div>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    username: String,
    position: Number,
    color: String,
    id: Number,
    playerId: Number,
    score: Number,
    order: Number,
});
</script>
