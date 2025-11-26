<template>
    <div :class="id === playerId ? 'bg-gradient-to-r from-green-500/15 to-green-600/5 border-2 border-green-500/95' : 'bg-gray-700'" class="flex items-center justify-between rounded-lg p-3">


        <div class="flex items-center space-x-3">
            <h2 class="text-sm font-bold text-white" >#{{ order }}</h2>
            <div :class="`w-8 h-8 bg-${color}-500 rounded-full flex items-center justify-center`">
                <span class="text-white font-bold text-sm" >{{ username.charAt(0).toUpperCase() }}</span>
            </div>
            <span class="font-medium text-gray-300" >{{ username }}</span>
            <span v-if="id === playerId" class="text-xs bg-[#39b54a] px-2 py-0.5 rounded-full text-white" >Current</span>
        </div>
        <div class="text-right flex items-center space-x-2">
            <div>
                <div class="text-xs text-gray-400" >Position</div>
                <div class="text-sm font-bold text-white" >{{ position }}</div>
            </div>
            <div>
                <div class="text-xs text-gray-400" >Score</div>
                <div class="text-sm font-bold text-white" >{{ score }}</div>
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
