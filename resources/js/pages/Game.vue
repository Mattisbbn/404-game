<template>
    <div  class="flex flex-col h-screen cursor-default-must">

        <section id="dice-section" class="flex-1 flex items-center justify-center px-6 py-8 section-clickable">
            <div class="text-center max-w-sm mx-auto">

                <div id="current-player" class="mb-6 section-clickable">
                    <div class="flex items-center justify-center space-x-2 mb-2">
                        <div class="w-8 h-8 bg-accent rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-sm" contenteditable="false">A</span>
                        </div>
                        <span class="text-lg font-semibold text-white" contenteditable="false">Alex's Turn</span>
                    </div>
                    <p class="text-sm text-gray-400" contenteditable="false">Tap the dice to roll</p>
                </div>



                <Dice />

                <div id="category-card" class="bg-gradient-to-r from-password/20 to-password/5 border-2 border-password rounded-xl p-6 hidden section-clickable">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-12 h-12 bg-password rounded-full flex items-center justify-center">
                            <i class="text-white text-xl" data-fa-i2svg=""><svg class="svg-inline--fa fa-shield-halved" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="shield-halved" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 0c4.6 0 9.2 1 13.4 2.9L457.7 82.8c22 9.3 38.4 31 38.3 57.2c-.5 99.2-41.3 280.7-213.6 363.2c-16.7 8-36.1 8-52.8 0C57.3 420.7 16.5 239.2 16 140c-.1-26.2 16.3-47.9 38.3-57.2L242.7 2.9C246.8 1 251.4 0 256 0zm0 66.8V444.8C394 378 431.1 230.1 432 141.4L256 66.8l0 0z"></path></svg></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2" contenteditable="false">Password Security</h3>
                    <p class="text-sm text-gray-300 mb-4" contenteditable="false">You landed on a Password Security question!</p>
                    <button class="w-full bg-password hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors" contenteditable="false">
                        Answer Question
                    </button>
                </div>

            </div>
        </section>

        <footer id="footer" class="px-6 py-6 border-t border-gray-800 section-clickable">
            <div class="max-w-sm mx-auto">

                <div id="game-legend" class="mb-4 section-clickable">
                    <h3 class="text-sm font-semibold text-white mb-3 text-center" contenteditable="false">Categories</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="flex items-center space-x-2 bg-gray-800 rounded-lg p-2">
                            <div class="w-4 h-4 rounded" :style="{ backgroundColor: colors.blue }"></div>
                            <span class="text-xs text-gray-300" contenteditable="false">Password</span>
                        </div>
                        <div class="flex items-center space-x-2 bg-gray-800 rounded-lg p-2">
                            <div class="w-4 h-4 rounded" :style="{ backgroundColor: colors.yellow }"></div>
                            <span class="text-xs text-gray-300" contenteditable="false">Phishing</span>
                        </div>
                        <div class="flex items-center space-x-2 bg-gray-800 rounded-lg p-2">
                            <div class="w-4 h-4 rounded" :style="{ backgroundColor: colors.green }"></div>
                            <span class="text-xs text-gray-300" contenteditable="false">Social Media</span>
                        </div>
                        <div class="flex items-center space-x-2 bg-gray-800 rounded-lg p-2">
                            <div class="w-4 h-4 rounded" :style="{ backgroundColor: colors.red }"></div>
                            <span class="text-xs text-gray-300" contenteditable="false">Cyber Risk</span>
                        </div>
                    </div>
                </div>

                <div id="player-order" class="bg-gray-800 rounded-xl p-4 section-clickable">
                    <h3 class="text-sm font-semibold text-white mb-3 flex items-center" contenteditable="false">
                        <i class="text-accent mr-2" data-fa-i2svg=""><svg class="svg-inline--fa fa-list-ol" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="list-ol" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M24 56c0-13.3 10.7-24 24-24H80c13.3 0 24 10.7 24 24V176h16c13.3 0 24 10.7 24 24s-10.7 24-24 24H40c-13.3 0-24-10.7-24-24s10.7-24 24-24H56V80H48C34.7 80 24 69.3 24 56zM86.7 341.2c-6.5-7.4-18.3-6.9-24 1.2L51.5 357.9c-7.7 10.8-22.7 13.3-33.5 5.6s-13.3-22.7-5.6-33.5l11.1-15.6c23.7-33.2 72.3-35.6 99.2-4.9c21.3 24.4 20.8 60.9-1.1 84.7L86.8 432H120c13.3 0 24 10.7 24 24s-10.7 24-24 24H32c-9.5 0-18.2-5.6-22-14.4s-2.1-18.9 4.3-25.9l72-78c5.3-5.8 5.4-14.6 .3-20.5zM224 64H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H224c-17.7 0-32-14.3-32-32s14.3-32 32-32zm0 160H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H224c-17.7 0-32-14.3-32-32s14.3-32 32-32zm0 160H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H224c-17.7 0-32-14.3-32-32s14.3-32 32-32z"></path></svg></i>
                        Player Order
                    </h3>
                    <div class="space-y-2">



                        <GamePlayerCard
                            v-for="player in activePlayers"
                            :key="player.id"
                            :username="player.username"
                            :position="player.position"
                            :color="player.color"
                            :player-id="player.id"
                            :id="player.id"
                        />


                    </div>
                </div>

            </div>
        </footer>

    </div>
</template>


<script setup>

import { onMounted, onUnmounted, ref } from 'vue';
import { useToast } from 'vue-toast-notification';
import GamePlayerCard from '../components/GamePlayerCard.vue';

const props = defineProps({
    gamecode: {
        type: String,
    },
});

import Dice from '../components/Dice.vue';
import { colors } from '../utils/colors';

const toast = useToast();
const activePlayers = ref([]);

onMounted(() => {
    window.Echo.join(`game.${props.gamecode}`)

        .here((users) => {
            activePlayers.value = users;
        })
        .joining((user) => {
            activePlayers.value.push(user);
            toast.info(`${user.username} has joined!`);
        })
        .leaving((user) => {
            activePlayers.value = activePlayers.value.filter((p) => p.id !== user.id);
            toast.error(`${user.username} has left.`);
        })
        // .listen('.PlayerStatusUpdated', (e) => {

        //     const playerIndex = activePlayers.value.findIndex((p) => p.id === e.userId);
        //     if (playerIndex !== -1) {
        //         activePlayers.value[playerIndex].status = e.status;
        //     }

        //     // Si c'est MOI qui ai changé (via une confirmation serveur), on met à jour mon bouton
        //     if (e.userId === props.playerId) {
        //         status.value = e.status;
        //     }
        // });
});

onUnmounted(() => {
    window.Echo.leave(`game.${props.gamecode}`);
});
</script>
