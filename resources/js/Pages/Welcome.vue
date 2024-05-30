<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <header>
        <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
                Dashboard
            </Link>

            <template v-else>
                <Link
                    :href="route('login')"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                    Se connecter
                </Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                    Créer un compte
                </Link>
            </template>
        </nav>
    </header>
    <section class="py-8">
        <div class="container mx-auto">
            <div class="bg-blue-500 text-white py-16">
                <div class="container mx-auto text-center">
                <h1 class="text-4xl font-bold mb-4">My Projeception - L'outil de gestion de vos projets</h1>
                <h2 class="text-2xl mb-4">Optimisez la gestion de vos projets avec notre plateforme faite par apprenants de l'EPSI pour des apprenants de l'EPSI.</h2>
                </div>
            </div>

            <div class="py-8">
                <div class="flex flex-wrap -mx-4">
                    <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
                        <h3 class="text-xl font-semibold mb-4">Fonctionnalités Principales</h3>
                        <ul class="list-disc list-inside">
                            <li>Suivi de l'avancement des projets</li>
                            <li>Gestion des collaborateurs</li>
                        </ul>
                    </div>
                    <!-- <div class="w-full md:w-2/3 px-4">
                        <h3 class="text-xl font-semibold mb-4">Témoignages</h3>
                        <div class="space-y-4">
                            <div v-for="testimonial in testimonials" :key="testimonial.name" class="p-4 border rounded">
                                <p class="font-bold">{{ testimonial.name }}</p>
                                <p>{{ testimonial.text }}</p>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </section>

    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
        Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
    </footer>
</template>