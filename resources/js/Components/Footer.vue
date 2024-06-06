<script>
    import { Link } from '@inertiajs/vue3';
    import axios from 'axios';
    import { version } from 'vue';

    /**
     * This component represents the footer section of the application.
     * It contains information and links related to the application's footer.
     */

    export default {
        components: {
            Link,
        },
        data() {
            return {
                laravelVersion: '',
                phpVersion: '',
                vueVersion: version,
            };
        },
        async created() {
            try {
                const response = await axios.get('/api/versions')
                this.laravelVersion = response.data.laravelVersion
                this.phpVersion = response.data.phpVersion
            } catch (error) {
                console.error('Une erreur est apparue:', error)
            }
        }
    };
</script>

<template>
    <footer class="flex-shrink-0 bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div class="flex space-x-6">
                    <span class="text-gray-500">© 2024 My Projeception. Tous droits réservés.</span>
                    <Link :href="route('terms')">Mentions légales</Link>
                    <Link :href="route('policy')">Politique de confidentialité</Link>
                    <span class="text-gray-500">
                        Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }}) | Vue v{{ vueVersion }}
                    </span>
                </div>
            </div>
        </div>
    </footer>
</template>