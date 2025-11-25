<template>
    <div class="bg-gray-800 rounded-xl p-4 flex items-center justify-between" :class="isMe ? 'bg-gradient-to-r from-green-500/15 to-green-600/5 border-2 border-green-500/95' : ''">
        <div class="flex items-center space-x-3">
            <div
                class="w-12 h-12 bg-gradient-to-br from-{{ color }}-500 to-{{ color }}-600 rounded-full flex items-center justify-center">
                <span class="text-white font-bold text-lg" contenteditable="false">{{ username.charAt(0).toUpperCase() }}</span>
            </div>
            <div>
                <span class="font-semibold text-white" contenteditable="false">{{ username }} <span v-if="isMe" class="text-xs bg-[#39b54a] px-2 py-0.5 rounded-full text-white font-semibold" >You</span></span>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <div class="w-3 h-3 bg-gray-600 rounded-full {{ status === 'ready' ? 'bg-green-500' : 'bg-gray-600' }}"></div>
            <span class="text-xs text-gray-500 font-medium" contenteditable="false">{{ status === 'ready' ? 'Ready' : 'Waiting' }}</span>
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
