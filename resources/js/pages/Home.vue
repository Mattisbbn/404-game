

<template>
    <Head title="Homepage"></Head>
    <header>


    </header>
    <main>
        <form class="flex flex-col" @submit.prevent="submitForm">
            <input v-model="username" type="text" placeholder="Username">
            <input v-model="gamecode" type="text" placeholder="Game code ">
            <button type="submit">Join a game</button>
        </form>
    </main>
    <footer>

    </footer>
</template>
<script setup>
    import { Head ,router} from '@inertiajs/vue3';
    import { ref } from 'vue';

    const username = ref('')
    const gamecode = ref('')

    const submitForm = () => {

        router.post('/join-game', {
            username: username.value,
            gamecode: gamecode.value,
        })
    }
</script>
