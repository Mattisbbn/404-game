<template>
    <div id="main-container" class="flex flex-col h-screen cursor-default-must">

        <section id="winner-section" class="px-6 py-8 text-center section-clickable">
            <div class="max-w-sm mx-auto">

                <div id="game-over-badge" class="mb-6 section-clickable">
                    <div class="inline-block bg-gradient-to-r from-accent to-green-600 px-4 py-2 rounded-full">
                        <span class="text-white font-semibold text-sm" contenteditable="false">Game Complete</span>
                    </div>
                </div>

                <div id="winner-announcement" class="mb-8 slide-up section-clickable">
                    <div class="relative">

                        <div class="absolute -top-2 -right-2 w-8 h-8  rounded-full flex items-center justify-center">
                            <i class="text-white text-sm" data-fa-i2svg=""><svg class="svg-inline--fa fa-crown" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="crown" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M309 106c11.4-7 19-19.7 19-34c0-22.1-17.9-40-40-40s-40 17.9-40 40c0 14.4 7.6 27 19 34L209.7 220.6c-9.1 18.2-32.7 23.4-48.6 10.7L72 160c5-6.7 8-15 8-24c0-22.1-17.9-40-40-40S0 113.9 0 136s17.9 40 40 40c.2 0 .5 0 .7 0L86.4 427.4c5.5 30.4 32 52.6 63 52.6H426.6c30.9 0 57.4-22.1 63-52.6L535.3 176c.2 0 .5 0 .7 0c22.1 0 40-17.9 40-40s-17.9-40-40-40s-40 17.9-40 40c0 9 3 17.3 8 24l-89.1 71.3c-15.9 12.7-39.5 7.5-48.6-10.7L309 106z"></path></svg></i>
                        </div>
                    </div>

                    <h2 class="text-3xl font-bold text-white mb-2" contenteditable="false">🎉 Congratulations! 🎉</h2>
                    <div class="flex items-center justify-center space-x-3 mb-2">
                        <div class="w-12 h-12 bg-accent rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-lg" contenteditable="false"> {{ leaderboard[0].username.charAt(0).toUpperCase() }}</span>
                        </div>
                        <span class="text-2xl font-bold text-white" contenteditable="false"> {{ leaderboard[0].username }}</span>
                    </div>
                    <p class="text-gray-400 text-sm" contenteditable="false">Winner with 50 points!</p>
                </div>

            </div>
        </section>

        <section id="leaderboard-section" class="flex-1 px-6 pb-6 section-clickable">
            <div class="max-w-sm mx-auto">

                <div id="leaderboard-header" class="mb-6 section-clickable">
                    <h3 class="text-xl font-bold text-white text-center flex items-center justify-center" contenteditable="false">
                        <i class="text-yellow-400 mr-2" data-fa-i2svg=""><svg class="svg-inline--fa fa-medal" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="medal" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M4.1 38.2C1.4 34.2 0 29.4 0 24.6C0 11 11 0 24.6 0H133.9c11.2 0 21.7 5.9 27.4 15.5l68.5 114.1c-48.2 6.1-91.3 28.6-123.4 61.9L4.1 38.2zm503.7 0L405.6 191.5c-32.1-33.3-75.2-55.8-123.4-61.9L350.7 15.5C356.5 5.9 366.9 0 378.1 0H487.4C501 0 512 11 512 24.6c0 4.8-1.4 9.6-4.1 13.6zM80 336a176 176 0 1 1 352 0A176 176 0 1 1 80 336zm184.4-94.9c-3.4-7-13.3-7-16.8 0l-22.4 45.4c-1.4 2.8-4 4.7-7 5.1L168 298.9c-7.7 1.1-10.7 10.5-5.2 16l36.3 35.4c2.2 2.2 3.2 5.2 2.7 8.3l-8.6 49.9c-1.3 7.6 6.7 13.5 13.6 9.9l44.8-23.6c2.7-1.4 6-1.4 8.7 0l44.8 23.6c6.9 3.6 14.9-2.2 13.6-9.9l-8.6-49.9c-.5-3 .5-6.1 2.7-8.3l36.3-35.4c5.6-5.4 2.5-14.8-5.2-16l-50.1-7.3c-3-.4-5.7-2.4-7-5.1l-22.4-45.4z"></path></svg></i>
                        Final Leaderboard
                    </h3>
                </div>

                <div id="leaderboard-list" class="space-y-3 section-clickable">

                        <div
                            v-for="(player, index) in leaderboard"
                            :key="player.id"
                            :class="[
                                'rounded-xl p-4 slide-up border-2 transition-colors duration-300',
                                getTheme(index).card
                            ]"
                        >
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">

                                    <div class="flex items-center space-x-3">
                                        <div
                                            :class="[
                                                'w-10 h-10 rounded-full flex items-center justify-center',
                                                getTheme(index).secondaryBadge
                                            ]"
                                        >
                                            <span class="text-white font-bold" contenteditable="false"> {{ player.username.charAt(0).toUpperCase() }}</span>
                                        </div>
                                        <div>
                                            <div class="font-bold text-white text-lg" contenteditable="false"> {{ player.username }}</div>
                                            <div
                                                :class="[
                                                    'text-xs font-medium',
                                                    getTheme(index).rankLabel
                                                ]"
                                                contenteditable="false"
                                            >
                                                🏆 {{ index + 1 }}th
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div
                                        :class="[
                                            'text-2xl font-bold',
                                            getTheme(index).score
                                        ]"
                                        contenteditable="false"
                                    >
                                        {{ player.score }}
                                    </div>
                                    <div class="text-xs text-gray-400" contenteditable="false">points</div>
                                </div>
                            </div>
                        </div>


                </div>

            </div>
        </section>



    </div>
</template>
<script setup>
import { computed } from 'vue';

const props = defineProps({
    leaderboard: {
        type: Array,
    },
});

const leaderboard = computed(() => {
    return props.leaderboard.map((player) => {
        return {
            username: player.username,
            score: player.score,
        };
    });
});

const podiumThemes = [
    {
        card: 'from-yellow-400/40 to-yellow-600/20 border-yellow-300 bg-gradient-to-r',
        primaryBadge: 'bg-gradient-to-br from-yellow-200 to-yellow-500 text-gray-900',
        secondaryBadge: 'bg-yellow-500/20 border border-yellow-300',
        crown: 'bg-yellow-500',
        rankLabel: 'text-yellow-300',
        score: 'text-yellow-300',
    },
    {
        card: 'from-gray-300/20 to-gray-500/10 border-gray-300 bg-gradient-to-r',
        primaryBadge: 'bg-gradient-to-br from-gray-200 to-gray-500 text-gray-900',
        secondaryBadge: 'bg-gray-500/30 border border-gray-300',
        crown: 'bg-gray-400',
        rankLabel: 'text-gray-200',
        score: 'text-gray-200',
    },
    {
        card: 'from-amber-700/20 to-orange-500/20 border-amber-600 bg-gradient-to-r',
        primaryBadge: 'bg-gradient-to-br from-amber-300 to-orange-600 text-gray-900',
        secondaryBadge: 'bg-orange-600/30 border border-amber-400',
        crown: 'bg-amber-500',
        rankLabel: 'text-amber-200',
        score: 'text-amber-200',
    },
];

const defaultTheme = {
    card: 'bg-gray-800/40 border-gray-700',
    primaryBadge: 'bg-gray-700 text-white',
    secondaryBadge: 'bg-purple-500',
    crown: 'bg-accent',
    rankLabel: 'text-gray-400',
    score: 'text-white',
};

const getTheme = (index) => {
    return podiumThemes[index] ?? defaultTheme;
};
</script>
