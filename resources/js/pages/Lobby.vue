<template>
    <div class="p-8 space-y-8">
        <Head title="Lobby" />
        <div>
            <h1 class="text-3xl font-semibold mb-4">Lobby</h1>
            <p class="text-lg">Code du lobby : <span class="font-mono">{{ gamecode }}</span></p>
            <div class="grid grid-cols-4 gap-4 mt-6">
                <div v-for="player in players" :key="player.id" class="bg-white p-4 rounded-lg">
                    <p class="text-lg">{{ player.username }}</p>
                </div>
            </div>
        </div>

        <div class="flex justify-center">
            <Dice />
        </div>
    </div>
</template>

<script setup>
    import { Head } from '@inertiajs/vue3';
    import Dice from '../components/Dice.vue';

    const props = defineProps({
        gamecode: {
            type: String,
        },
        players: {
            type: Object,
        },
    });

    const gamecode = props.gamecode;
</script>
