<template>
    <main class="section-clickable flex-1 overflow-y-auto px-6 py-6">
        <div class="mx-auto max-w-sm">
            <div id="game-info" class="section-clickable mb-8 text-center">
                <div class="mb-4 inline-flex items-center space-x-2 rounded-full bg-gray-800 px-6 py-3">
                    <Icon icon="mdi:hashtag" class="text-accent text-2xl text-[#39b54a]" />
                    <span class="text-2xl font-bold tracking-wider text-white" contenteditable="false">{{ gamecode }}</span>
                    <button class="hover:text-accent ml-2 cursor-pointer text-gray-400 transition-colors" @click="copyGamecode">
                        <Icon icon="mdi:content-copy" class="text-xl" />
                    </button>
                </div>
                <p class="text-sm text-gray-400" contenteditable="false">Share this code with your friends</p>
            </div>

            <div id="players-section" class="section-clickable mb-8">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-white" contenteditable="false">Players</h2>
                    <span
                        class="flex items-center space-x-2 rounded-full bg-gray-800 px-3 py-1 text-sm font-medium text-white"
                        contenteditable="false"
                        ><Icon icon="mdi:users" class="text-accent me-1 text-sm" /> {{ numbersOfPlayers }}/8</span
                    >
                </div>

                <div id="players-list" class="section-clickable space-y-3">
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
                id="ready-btn"
                class="section-clickable flex w-full transform items-center justify-center space-x-3 rounded-xl px-6 py-4 font-semibold text-white shadow-lg transition-all duration-200 hover:scale-[1.02] hover:bg-green-500 active:scale-[0.98]"
                :class="[
                    status === 'waiting' ? 'bg-[#39b54a]' : 'bg-gray-500',
                    isUpdatingStatus ? 'cursor-not-allowed opacity-70' : 'cursor-pointer'
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
        <!-- <Dice /> -->
    </main>
</template>

<script setup>
import { Icon } from '@iconify/vue';
import axios from 'axios';
import { onMounted, onUnmounted, ref,computed } from 'vue';
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
const activePlayers = ref( []);
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
        // 2. REJOINT : Quelqu'un arrive
        .joining((user) => {
            activePlayers.value.push(user);
            toast.info(`${user.username} has joined!`);
        })
        // 3. DÉPART : Quelqu'un part
        .leaving((user) => {
            activePlayers.value = activePlayers.value.filter((p) => p.id !== user.id);
            toast.error(`${user.username} has left.`);
        })
        // 4. ÉVÉNEMENT : Quelqu'un change de statut
        .listen('.PlayerStatusUpdated', (e) => {

            // On trouve le joueur dans la liste et on change son statut
            const playerIndex = activePlayers.value.findIndex((p) => p.id === e.userId);
            if (playerIndex !== -1) {
                activePlayers.value[playerIndex].status = e.status;
            }

            // Si c'est MOI qui ai changé (via une confirmation serveur), on met à jour mon bouton
            if (e.userId === props.playerId) {
                status.value = e.status;
            }
        });
});

onUnmounted(() => {
    window.Echo.leave(`game.${props.gamecode}`);
});

const playerId = props.playerId;
</script>
