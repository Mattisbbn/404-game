<template>
    <div :class="id === playerId ? 'bg-gradient-to-r from-green-500/15 to-green-600/5 border-2 border-green-500/95' : 'bg-gray-700'" class="flex items-center justify-between rounded-lg p-3">
        <div class="flex items-center space-x-3">
            <div :class="`w-8 h-8 bg-${color}-500 rounded-full flex items-center justify-center`">
                <span class="text-white font-bold text-sm" contenteditable="false">{{ username.charAt(0).toUpperCase() }}</span>
            </div>
            <span class="font-medium text-gray-300" contenteditable="false">{{ username }}</span>
            <span v-if="id === playerId" class="text-xs bg-[#39b54a] px-2 py-0.5 rounded-full text-white" contenteditable="false">Current</span>
        </div>
        <div class="text-right">
            <div class="text-xs text-gray-400" contenteditable="false">Position</div>
            <div class="text-sm font-bold text-white" contenteditable="false">{{ position }}</div>
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
});


</script>
