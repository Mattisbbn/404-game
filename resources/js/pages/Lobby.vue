<template>
    <main class="section-clickable flex-1 overflow-y-auto px-6 py-6">
        <div class="mx-auto max-w-sm">
            <div id="game-info" class="section-clickable mb-8 text-center">
                <div class="mb-4 inline-flex items-center space-x-2 rounded-full bg-gray-800 px-6 py-3">
                    <Icon icon="mdi:hashtag" class="text-accent text-2xl text-white" />
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
                    <!-- <div class="bg-gradient-to-r from-accent/20 to-accent/5 border-2 border-accent rounded-xl p-4 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-accent rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-lg" contenteditable="false">A</span>
                                </div>
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span class="font-semibold text-white" contenteditable="false">Alex</span>
                                        <span class="text-xs bg-accent px-2 py-0.5 rounded-full text-white font-medium" contenteditable="false">You</span>
                                    </div>
                                    <div class="flex items-center space-x-1 mt-1">
                                        <i class="text-yellow-400 text-xs" data-fa-i2svg=""><svg class="svg-inline--fa fa-crown" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="crown" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M309 106c11.4-7 19-19.7 19-34c0-22.1-17.9-40-40-40s-40 17.9-40 40c0 14.4 7.6 27 19 34L209.7 220.6c-9.1 18.2-32.7 23.4-48.6 10.7L72 160c5-6.7 8-15 8-24c0-22.1-17.9-40-40-40S0 113.9 0 136s17.9 40 40 40c.2 0 .5 0 .7 0L86.4 427.4c5.5 30.4 32 52.6 63 52.6H426.6c30.9 0 57.4-22.1 63-52.6L535.3 176c.2 0 .5 0 .7 0c22.1 0 40-17.9 40-40s-17.9-40-40-40s-40 17.9-40 40c0 9 3 17.3 8 24l-89.1 71.3c-15.9 12.7-39.5 7.5-48.6-10.7L309 106z"></path></svg></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-accent rounded-full animate-pulse"></div>
                                <span class="text-xs text-accent font-medium" contenteditable="false">Ready</span>
                            </div>
                        </div> -->

                    <UserCard v-for="player in players" :is-me="player.id === playerid" :key="player.id" :username="player.username" :status="player.status" :color="player.color" />
                </div>
            </div>
            <!--
                <div id="game-settings" class="bg-gray-800 rounded-xl p-4 mb-6 section-clickable">
                    <h3 class="text-sm font-semibold text-white mb-3 flex items-center" contenteditable="false">
                        <i class="text-accent mr-2" data-fa-i2svg=""><svg class="svg-inline--fa fa-sliders" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="sliders" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M0 416c0 17.7 14.3 32 32 32l54.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48L480 448c17.7 0 32-14.3 32-32s-14.3-32-32-32l-246.7 0c-12.3-28.3-40.5-48-73.3-48s-61 19.7-73.3 48L32 384c-17.7 0-32 14.3-32 32zm128 0a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zM320 256a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm32-80c-32.8 0-61 19.7-73.3 48L32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l246.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48l54.7 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-54.7 0c-12.3-28.3-40.5-48-73.3-48zM192 128a32 32 0 1 1 0-64 32 32 0 1 1 0 64zm73.3-64C253 35.7 224.8 16 192 16s-61 19.7-73.3 48L32 64C14.3 64 0 78.3 0 96s14.3 32 32 32l86.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48L480 128c17.7 0 32-14.3 32-32s-14.3-32-32-32L265.3 64z"></path></svg></i>

                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-400" contenteditable="false">Max Players</span>
                            <span class="text-sm text-white font-medium" contenteditable="false">8</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-400" contenteditable="false">Game Mode</span>
                            <span class="text-sm text-white font-medium" contenteditable="false">Classic</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-400" contenteditable="false">Round Time</span>
                            <span class="text-sm text-white font-medium" contenteditable="false">60s</span>
                        </div>
                    </div>
                </div> -->
                <button id="ready-btn" class="w-full cursor-pointer bg-[#39b54a] hover:bg-green-500 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] shadow-lg flex items-center justify-center space-x-3 section-clickable">
                   <Icon icon="mdi:check" class="text-xl color-transparent" />
                    <p class="text-lg" contenteditable="false">I'm Ready!</p>
                </button>
        </div>


    </main>
</template>

<script setup>
import { Icon } from '@iconify/vue';
import { useToast } from 'vue-toast-notification';
import UserCard from '../components/UserCard.vue';

const props = defineProps({
    gamecode: {
        type: String,
    },
    players: {
        type: Object,
    },
    playerId: {
        type: Number,
    },
});

const gamecode = props.gamecode;
const players = props.players;
const numbersOfPlayers = players.length;

const toast = useToast();

const copyGamecode = async () => {
    await navigator.clipboard.writeText(gamecode);
    toast.success('Game code copied to clipboard !', {
        duration: 3000,
        position: 'top-right',
    });
};

const playerid = props.playerId;

</script>
