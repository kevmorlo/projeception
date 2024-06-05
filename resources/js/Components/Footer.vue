<script>
    import { Link } from '@inertiajs/vue3';
    import axios from 'axios';

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
            };
        },
        created() {
            axios.get('/api/versions').then(response => {
                this.laravelVersion = response.data.laravelVersion;
                this.phpVersion = response.data.phpVersion;
            })
        }
    };
</script>

<template>
    <div class="pt-10 bg-gray-100">
        <footer class="mt-auto inset-x-0 bottom-0 bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <div class="flex space-x-6">
                        <span class="text-gray-500">© 2024 My Projeception. Tous droits réservés.</span>
                        <Link :href="route('terms')">Mentions légales</Link>
                        <Link :href="route('policy')">Politique de confidentialité</Link>
                        <span class="text-gray-500">
                            Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                        </span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>