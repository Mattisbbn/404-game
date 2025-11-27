<template>
    <div class="relative">
        <input
            v-model="model"
            :maxlength="maxlength || null"
            :minlength="minlength || null"
            :type="type"
            :placeholder="placeholder"
            class="focus:border-accent focus:ring-accent/20 section-clickable w-full rounded-xl border border-gray-700 bg-gray-800 px-4 py-4 text-white placeholder-gray-500 transition-all duration-200 focus:ring-2 focus:outline-none"
        />
        <i class="absolute top-1/2 right-4 -translate-y-1/2 transform text-gray-500" data-fa-i2svg=""
            ><svg
                class="svg-inline--fa fa-user"
                aria-hidden="true"
                focusable="false"
                data-prefix="fas"
                data-icon="user"
                role="img"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 448 512"
                data-fa-i2svg=""
            >
                <path
                    fill="currentColor"
                    d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"
                ></path></svg
        ></i>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: '',
    },
    placeholder: {
        type: String,
        default: '',
    },
    maxlength: {
        type: Number,
        default: 0,
    },
    minlength: {
        type: Number,
        default: 0,
    },
    type: {
        type: String,
        default: 'text',
    },
});

const emit = defineEmits(['update:modelValue']);

const model = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
});
</script>
