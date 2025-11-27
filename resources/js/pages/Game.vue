<template>
    <Head :title="`Game ${gamecode}`"></Head>
    <div class="cursor-default-must flex min-h-dvh flex-col">
        <section id="dice-section" class="section-clickable relative flex flex-1 items-center justify-center px-6 py-8">
            <transition name="fade">
                <div
                    v-if="showSpecialPopup"
                    class="pointer-events-none absolute inset-x-4 top-6 z-10 mx-auto max-w-lg"
                >
                    <div
                        class="rounded-2xl border px-6 py-4 text-center shadow-xl backdrop-blur"
                        :class="[specialPopupClasses.bg, specialPopupClasses.border]"
                    >
                        <p class="text-xs font-semibold uppercase tracking-widest text-gray-200">{{ specialPopup.type }}</p>
                        <h4 class="mt-1 text-lg font-bold text-white">{{ specialPopup.title }}</h4>
                        <p class="mt-2 text-sm text-gray-100/90">{{ specialPopup.message }}</p>
                    </div>
                </div>
            </transition>
            <div class="mx-auto max-w-lg text-center">
                <div id="current-player" class="section-clickable mb-6">
                    <div class="mb-2 flex items-center justify-center space-x-2">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full border-2 border-[#39b54a] bg-[#1A3D3C]">
                            <span class="text-sm font-bold text-white">{{ currentPlayer?.username.charAt(0).toUpperCase() }}</span>
                        </div>
                        <span class="text-lg font-semibold text-white">{{ currentPlayer?.username }}'s Turn</span>
                    </div>
                    <p class="text-sm text-gray-400">Tap the dice to roll</p>
                </div>

                <Dice :canRoll="currentPlayer?.canRoll && currentPlayerId === props.playerId" @roll-finished="handleDiceRollFinished" />

                <div
                    id="category-card"
                    class="from-password/20 to-password/5 border-password section-clickable hidden rounded-xl border-2 bg-gradient-to-r p-6"
                >
                    <div class="mb-4 flex items-center justify-center">
                        <div class="bg-password flex h-12 w-12 items-center justify-center rounded-full">
                            <i class="text-xl text-white" data-fa-i2svg=""
                                ><svg
                                    class="svg-inline--fa fa-shield-halved"
                                    aria-hidden="true"
                                    focusable="false"
                                    data-prefix="fas"
                                    data-icon="shield-halved"
                                    role="img"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512"
                                    data-fa-i2svg=""
                                >
                                    <path
                                        fill="currentColor"
                                        d="M256 0c4.6 0 9.2 1 13.4 2.9L457.7 82.8c22 9.3 38.4 31 38.3 57.2c-.5 99.2-41.3 280.7-213.6 363.2c-16.7 8-36.1 8-52.8 0C57.3 420.7 16.5 239.2 16 140c-.1-26.2 16.3-47.9 38.3-57.2L242.7 2.9C246.8 1 251.4 0 256 0zm0 66.8V444.8C394 378 431.1 230.1 432 141.4L256 66.8l0 0z"
                                    ></path></svg
                            ></i>
                        </div>
                    </div>
                    <h3 class="mb-2 text-lg font-bold text-white">Password Security</h3>
                    <p class="mb-4 text-sm text-gray-300">You landed on a Password Security question!</p>
                    <button class="bg-password w-full rounded-lg px-6 py-3 font-semibold text-white transition-colors hover:bg-blue-600">
                        Answer Question
                    </button>
                </div>
            </div>
        </section>

        <footer id="footer" class="section-clickable border-t border-gray-800 px-6 py-6">
            <div class="mx-auto max-w-lg">
                <div id="game-legend" class="section-clickable mb-4">
                    <h3 class="mb-3 text-center text-sm font-semibold text-white">Categories</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="flex items-center space-x-2 rounded-lg bg-gray-800 p-2">
                            <div class="h-4 w-4 rounded" :style="{ backgroundColor: colors.blue }"></div>
                            <span class="text-xs text-gray-300">Password</span>
                        </div>
                        <div class="flex items-center space-x-2 rounded-lg bg-gray-800 p-2">
                            <div class="h-4 w-4 rounded" :style="{ backgroundColor: colors.yellow }"></div>
                            <span class="text-xs text-gray-300">Phishing</span>
                        </div>
                        <div class="flex items-center space-x-2 rounded-lg bg-gray-800 p-2">
                            <div class="h-4 w-4 rounded" :style="{ backgroundColor: colors.green }"></div>
                            <span class="text-xs text-gray-300">Social Media</span>
                        </div>
                        <div class="flex items-center space-x-2 rounded-lg bg-gray-800 p-2">
                            <div class="h-4 w-4 rounded" :style="{ backgroundColor: colors.red }"></div>
                            <span class="text-xs text-gray-300">Cyber Risk</span>
                        </div>
                    </div>
                </div>

                <div id="player-order" class="section-clickable rounded-xl bg-gray-800 p-4">
                    <h3 class="mb-3 flex items-center text-sm font-semibold text-white">
                        <i class="text-accent mr-2" data-fa-i2svg=""
                            ><svg
                                class="svg-inline--fa fa-list-ol"
                                aria-hidden="true"
                                focusable="false"
                                data-prefix="fas"
                                data-icon="list-ol"
                                role="img"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512 512"
                                data-fa-i2svg=""
                            >
                                <path
                                    fill="currentColor"
                                    d="M24 56c0-13.3 10.7-24 24-24H80c13.3 0 24 10.7 24 24V176h16c13.3 0 24 10.7 24 24s-10.7 24-24 24H40c-13.3 0-24-10.7-24-24s10.7-24 24-24H56V80H48C34.7 80 24 69.3 24 56zM86.7 341.2c-6.5-7.4-18.3-6.9-24 1.2L51.5 357.9c-7.7 10.8-22.7 13.3-33.5 5.6s-13.3-22.7-5.6-33.5l11.1-15.6c23.7-33.2 72.3-35.6 99.2-4.9c21.3 24.4 20.8 60.9-1.1 84.7L86.8 432H120c13.3 0 24 10.7 24 24s-10.7 24-24 24H32c-9.5 0-18.2-5.6-22-14.4s-2.1-18.9 4.3-25.9l72-78c5.3-5.8 5.4-14.6 .3-20.5zM224 64H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H224c-17.7 0-32-14.3-32-32s14.3-32 32-32zm0 160H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H224c-17.7 0-32-14.3-32-32s14.3-32 32-32zm0 160H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H224c-17.7 0-32-14.3-32-32s14.3-32 32-32z"
                                ></path></svg
                        ></i>
                        Player Order
                    </h3>
                    <div class="space-y-2">
                        <GamePlayerCard
                            v-for="player in activePlayers"
                            :key="player.id"
                            :username="player.username"
                            :position="player.position"
                            :color="player.color"
                            :player-id="currentPlayerId"
                            :id="player.id"
                            :score="player.score"
                            :order="player.order"
                        />
                    </div>
                </div>
            </div>
        </footer>

        <div v-if="showQuizPopup" class="fixed inset-0 z-50 flex items-center justify-center bg-[#111827]">
            <QuizPopup :question="question" @close="handleCloseQuiz" @submit="handleSubmitQuiz" />
        </div>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { computed, onMounted, onUnmounted, ref } from 'vue';
import { useToast } from 'vue-toast-notification';
import Dice from '../components/Dice.vue';
import GamePlayerCard from '../components/GamePlayerCard.vue';
import QuizPopup from '../components/QuizPopup.vue';
import { colors } from '../utils/colors';

const props = defineProps({
    gamecode: {
        type: String,
    },
    currentPlayerId: {
        type: Number,
        default: null,
    },
    playerId: {
        type: Number,
        default: null,
    },
});

const toast = useToast();
const activePlayers = ref([]);
const currentPlayerId = ref(props.currentPlayerId ?? null);
const currentPlayer = computed(() => activePlayers.value.find((player) => player.id === currentPlayerId.value));
const showSpecialPopup = ref(false);
const specialPopup = ref({
    title: '',
    message: '',
    type: '',
});
const specialPopupClasses = computed(() => {
    switch (specialPopup.value.type) {
        case 'bonus':
            return { bg: 'bg-emerald-500/20', border: 'border-emerald-400/60' };
        case 'malus':
            return { bg: 'bg-rose-500/20', border: 'border-rose-400/60' };
        case 'prison':
            return { bg: 'bg-amber-500/20', border: 'border-amber-400/60' };
        default:
            return { bg: 'bg-slate-500/20', border: 'border-slate-400/60' };
    }
});
const showQuizPopup = ref(false);
const question = ref({});
let specialPopupTimeout = null;

const restorePendingQuestion = () => {
    const currentUser = activePlayers.value.find((player) => player.id === props.playerId);
    if (currentUser?.question) {
        question.value = currentUser.question;
        showQuizPopup.value = true;
    }
};

const handleSubmitQuiz = (answer) => {
    axios
        .post(`/answer-question/${props.gamecode}`, {
            answer: answer,
            questionId: question.value.id,
            playerId: props.playerId,
        })
        .then((response) => {
            if (!response.data.success) {
                toast.error(response.data.message);
            } else {
                showQuizPopup.value = false;
                if (response.data.question) {
                    question.value = response.data.question;
                }
                if (response.data.isCorrect) {
                    toast.success('Correct answer!');
                } else {
                    toast.error('Wrong answer!');
                }
            }
        });
};

const handleCloseQuiz = () => {
    showQuizPopup.value = false;
};

const showTemporaryPopup = (payload) => {
    window.clearTimeout(specialPopupTimeout);
    specialPopup.value = payload;
    showSpecialPopup.value = true;
    specialPopupTimeout = window.setTimeout(() => {
        showSpecialPopup.value = false;
    }, 4000);
};

const handleDiceRollFinished = (value) => {
    axios
        .post(`/roll-dice/${props.gamecode}`, {
            result: value,
            playerId: props.playerId,
        })
        .then((response) => {
            console.log(response.data);
            if (!response.data.success) {
                toast.error(response.data.message);
            }
        })
        .catch((error) => {
            console.log(error);
        });
};

onMounted(() => {
    window.Echo.join(`game.${props.gamecode}`)
        .here((users) => {
            activePlayers.value = users;
            restorePendingQuestion();
        })
        .joining((user) => {
            activePlayers.value.push(user);
            toast.info(`${user.username} has joined!`);
        })
        .leaving((user) => {
            activePlayers.value = activePlayers.value.filter((p) => p.id !== user.id);
            toast.error(`${user.username} has left.`);
        })
        .listen('.GameRealtimeEvent', (event) => {
            if (event.type === 'rollDiceResult') {
                console.log(event.data);
                const affectedPlayer = activePlayers.value.find((player) => player.id === event.data.player_id);
                if (affectedPlayer) {
                    affectedPlayer.position = event.data.position;
                    if (event.data.score !== undefined) {
                        affectedPlayer.score = event.data.score;
                    }
                    if (event.data.prison_turns !== undefined) {
                        affectedPlayer.prison_turns = event.data.prison_turns;
                    }
                    if (!event.data.requiresQuestion) {
                        affectedPlayer.question = null;
                    }
                }
                // Mettre à jour canRoll pour tous les joueurs
                if (event.data.canRoll !== undefined) {
                    activePlayers.value.forEach((player) => {
                        player.canRoll = event.data.canRoll;
                    });
                }

                if (event.data.bonus === true && event.data.player_id === props.playerId) {
                    showTemporaryPopup({
                        title: 'Bonus +2 points',
                        message: 'Excellent ! you gain 2 points without answering a quiz.',
                        type: 'bonus',
                    });
                } else if(event.data.malus === true && event.data.player_id === props.playerId) {
                    showTemporaryPopup({
                        title: 'Malus -2 points',
                        message: 'Oops ! you lose 2 points immediately.',
                    type: 'malus',
                });
            } else if (event.data.prison_turns && event.data.player_id === props.playerId) {
                showTemporaryPopup({
                    title: 'You are in prison',
                    message: 'Your next turn is blocked. Please wait a moment!',
                    type: 'prison',
                });
            }

                toast.success(`${affectedPlayer?.username} has rolled a ${event.data.result}!`);
            } else if (event.type === 'question') {
                const targetPlayer = activePlayers.value.find((player) => player.id === event.data.player_id);
                if (targetPlayer) {
                    targetPlayer.question = event.data.question;
                }
                // Afficher le quiz uniquement pour le joueur concerné
                if (event.data.player_id === props.playerId) {
                    question.value = event.data.question;
                    showQuizPopup.value = true;
                }
            } else if (event.type === 'questionAnsweredResult') {
                const affectedPlayer = activePlayers.value.find((player) => player.id === event.data.player_id);
                if (affectedPlayer) {
                    affectedPlayer.score = event.data.score;
                    affectedPlayer.question = null;
                }
                // Réactiver canRoll pour tous les joueurs après avoir répondu
                if (event.data.canRoll !== undefined) {
                    activePlayers.value.forEach((player) => {
                        player.canRoll = event.data.canRoll;
                    });
                }
                if (event.data.player_id === props.playerId) {
                    showQuizPopup.value = false;
                    question.value = {};
                }
            }
        })
        .listen('.CurrentPlayerUpdated', (event) => {
            console.log(event);
            const updatedId = Number(event.userId);
            if (event.is_current) {
                currentPlayerId.value = updatedId;
            } else if (currentPlayerId.value === updatedId) {
                currentPlayerId.value = null;
            }
        });
});

onUnmounted(() => {
    window.Echo.leave(`game.${props.gamecode}`);
});
</script>
