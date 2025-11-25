<template>
    <Head title="Homepage"></Head>

    <main class="cursor-default-must flex h-screen flex-col">
        <section id="hero-section" class="section-clickable flex flex-1 flex-col justify-center px-6">
            <div class="mx-auto w-full max-w-sm">
                <div id="logo-area" class="section-clickable mb-6 text-center">
                    <div
                        class="from-accent mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-3xl bg-gradient-to-br to-green-400 shadow-2xl"
                    >
                    <img :src="logo" alt="logo" class="h-18  object-contain" />
                    </div>
                    <h2 class="mb-3 text-3xl font-bold text-white" contenteditable="false">404</h2>
                    <p class="text-lg text-gray-400" contenteditable="false">desc</p>
                </div>

                <form id="game-form" class="section-clickable space-y-6" @submit.prevent="form.post('/join-game')">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300" contenteditable="false">Username</label>
                        <Input v-model="form.username" placeholder="Username" />
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300" contenteditable="false">Game code</label>
                        <Input v-model="form.gamecode" placeholder="Game code" :maxlength="6" />
                    </div>

                    <button
                        class="section-clickable flex w-full cursor-pointer items-center justify-center rounded-xl bg-[#39b54a] px-6 py-4 text-lg font-semibold text-white shadow-lg transition-all duration-200 hover:bg-green-500 hover:shadow-xl"
                        :disabled="form.processing"
                        type="submit"
                    >
                        <Icon v-if="!form.processing" icon="ion:play" class="mr-3 text-2xl" />
                        <Icon v-else icon="eos-icons:loading" class="mr-3 animate-spin text-2xl" />
                        <span v-if="!form.processing">Join / Create a game</span>
                        <span v-else>Loading...</span>
                    </button>

                </form>
            </div>
        </section>
    </main>
</template>

<script setup>
    import logo from '../../img/logo.svg';



    import { Icon } from '@iconify/vue';
    import { Head, useForm } from '@inertiajs/vue3';
    import Input from '../components/Input.vue';
    const form = useForm({
        username: '',
        gamecode: '',
    });
</script>
