<script>
    import { Link } from '@inertiajs/vue3';

    /**
     * This component represents the footer section of the application.
     * It contains information and links related to the application's footer.
     */

    export default {
        components: {
            Link,
        },
        props: {
            laravelVersion: {
                type: String,
                required: true,
            },
            phpVersion: {
                type: String,
                required: true,
            },
        },
    };
</script>

<template>
    <footer class="bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div class="flex space-x-6">
                    <span class="text-sm text-gray-500">© 2024 My Projeception. Tous droits réservés.</span>
                    <Link :href="route('mentionsLegales')">Mentions légales</Link>
                    <Link :href="route('politiqueConfidentialite')">Politique de confidentialité</Link>
                    <a href="/politique-confidentialite">Politique de confidentialité</a>
                    <span class="py-16 text-center text-sm text-black">
                        Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                    </span>
                </div>
            </div>
        </div>
    </footer>
</template>