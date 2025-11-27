<template>
    <div
        class="flex items-center justify-between rounded-xl bg-gray-800 p-4"
        :class="isMe ? 'border-2 border-green-500/95 bg-gradient-to-r from-green-500/15 to-green-600/5' : ''"
    >
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-gradient-to-br from-{{ color }}-500 to-{{ color }}-600 rounded-full flex items-center justify-center">
                <span class="text-lg font-bold text-white" contenteditable="false">{{ username.charAt(0).toUpperCase() }}</span>
            </div>
            <div>
                <span class="font-semibold text-white" contenteditable="false"
                    >{{ username }} <span v-if="isMe" class="rounded-full bg-[#39b54a] px-2 py-0.5 text-xs font-semibold text-white">You</span></span
                >
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <div :class="status === 'ready' ? 'bg-green-500' : 'bg-gray-600'" class="h-3 w-3 rounded-full bg-gray-600"></div>
            <span
                :class="status === 'ready' ? 'text-green-500' : 'text-gray-500'"
                class="text-xs font-medium text-gray-500"
                contenteditable="false"
                >{{ status === 'ready' ? 'Ready' : 'Waiting' }}</span
            >
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    username: String,
    status: String,
    color: String,
    isMe: Boolean,
});
</script>
