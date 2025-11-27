<template>
    <main class="min-h-dvh px-6 py-6">
        <div class="mx-auto max-w-lg">
            <div class="mb-8 text-center">
                <div class="mb-4 inline-flex items-center space-x-2 rounded-full bg-gray-800 px-6 py-3">
                    <Icon icon="mdi:hashtag" class="text-accent text-2xl text-[#39b54a]" />
                    <span class="text-2xl font-bold tracking-wider text-white">{{ gamecode }}</span>
                    <button class="hover:text-accent ml-2 cursor-pointer text-gray-400 transition-colors" @click="copyGamecode">
                        <Icon icon="mdi:content-copy" class="text-xl" />
                    </button>
                </div>
                <p class="text-sm text-gray-400">Share this code with your friends</p>
            </div>

            <div class="mb-8">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-white">Players</h2>
                    <span class="flex items-center space-x-2 rounded-full bg-gray-800 px-3 py-1 text-sm font-medium text-white">
                        <Icon icon="mdi:users" class="text-accent me-1 text-sm" /> {{ numbersOfPlayers }}/8
                    </span>
                </div>

                <div class="space-y-3">
                    <div v-if="isLoadingPlayers" class="flex items-center justify-center py-8">
                        <Icon icon="eos-icons:loading" class="animate-spin text-4xl text-[#39b54a]" />
                    </div>
                    <template v-else>
                        <UserCard
                            v-for="player in activePlayers"
                            :is-me="player.id === playerId"
                            :key="player.id"
                            :username="player.username"
                            :status="player.id === playerId ? status : player.status"
                            :color="player.color"
                        />
                    </template>
                </div>
            </div>

            <button
                class="flex w-full transform items-center justify-center space-x-3 rounded-xl px-6 py-4 font-semibold text-white shadow-lg transition-all duration-200 hover:scale-[1.02] hover:bg-green-500 active:scale-[0.98]"
                :class="[
                    status === 'waiting' ? 'bg-[#39b54a]' : 'bg-gray-500',
                    isUpdatingStatus ? 'cursor-not-allowed opacity-70' : 'cursor-pointer',
                ]"
                @click="changePlayerStatus"
                :disabled="isUpdatingStatus"
            >
                <Icon v-if="isUpdatingStatus" icon="eos-icons:loading" class="animate-spin text-xl" />
                <Icon v-else icon="mdi:check" class="color-transparent text-xl" />
                <p v-if="isUpdatingStatus" class="text-lg">Updating...</p>
                <p v-else-if="status === 'waiting'" class="text-lg">I'm Ready!</p>
                <p v-else class="text-lg">I'm Not Ready!</p>
            </button>
        </div>
    </main>
</template>

<script setup>
import { Icon } from '@iconify/vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { computed, onMounted, onUnmounted, ref } from 'vue';
import { useToast } from 'vue-toast-notification';
import UserCard from '../components/UserCard.vue';

const props = defineProps({
    gamecode: {
        type: String,
    },

    playerId: {
        type: Number,
    },
    status: {
        type: String,
    },
});

const gamecode = props.gamecode;
const activePlayers = ref([]);
const isLoadingPlayers = ref(true);
const isUpdatingStatus = ref(false);
const numbersOfPlayers = computed(() => activePlayers.value.length);
const status = ref(props.status);
const toast = useToast();

const copyGamecode = async () => {
    await navigator.clipboard.writeText(gamecode);
    toast.success('Game code copied to clipboard !', {
        duration: 3000,
        position: 'top-right',
    });
};

const changePlayerStatus = () => {
    if (isUpdatingStatus.value) return;

    isUpdatingStatus.value = true;
    axios
        .post(`/update-player-status/${playerId}`, {
            status: status.value === 'waiting' ? 'ready' : 'waiting',
        })
        .then((response) => {
            toast.success('Player status updated !', {
                duration: 3000,
                position: 'top-right',
            });
            status.value = response.data.status;
        })
        .catch((error) => {
            toast.error('Failed to update status', {
                duration: 3000,
                position: 'top-right',
            });
        })
        .finally(() => {
            isUpdatingStatus.value = false;
        });
};

onMounted(() => {
    window.Echo.join(`game.${props.gamecode}`)
        .here((users) => {
            activePlayers.value = users;
            isLoadingPlayers.value = false;
        })
        .joining((user) => {
            activePlayers.value.push(user);
            toast.info(`${user.username} has joined!`);
        })
        .leaving((user) => {
            activePlayers.value = activePlayers.value.filter((p) => p.id !== user.id);
            toast.error(`${user.username} has left.`);
        })
        .listen('.PlayerStatusUpdated', (e) => {
            const playerIndex = activePlayers.value.findIndex((p) => p.id === e.userId);
            if (playerIndex !== -1) {
                activePlayers.value[playerIndex].status = e.status;
            }
            if (e.userId === props.playerId) {
                status.value = e.status;
            }
        })
        .listen('.GameStarted', (event) => {
            toast.success('Game is starting!', {
                duration: 2000,
                position: 'top-right',
            });
            router.visit(`/game/${event.gamecode ?? gamecode}`);
        });
});

onUnmounted(() => {
    window.Echo.leave(`game.${props.gamecode}`);
});

const playerId = props.playerId;
</script>
