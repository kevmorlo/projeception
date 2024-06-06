<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Footer from '@/Components/Footer.vue';
import { Link } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

export default {
    components: {
        AppLayout,
        ApplicationLogo,
        Footer,
        Link,
    },
    setup() {
        const { props } = usePage();
        console.log('Props:', props);
        const teamId = props.teamId;
        const project = ref({
                title: '',
                team_id: teamId,
                description: '',
            });
        const errorMessage = ref(null);

        async function createProject() {
            try {
                console.log('Sending project to server:', project.value);
                const response = await axios.post('/projects', project.value);
                if (response && response.data) {
                    Inertia.visit(`/projects/${response.data.id}`);
                } else {
                    throw new Error('La réponse du serveur est vide');
                }
            } catch (error) {
                console.error(error);
                if (error.response && error.response.data && error.response.data.error) {
                    errorMessage.value = error.response.data.error;
                } else {
                    errorMessage.value = 'Une erreur inattendue s\'est produite.';
                }
            }
        }

        return {
            teamId,
            project,
            createProject,
            errorMessage,
        };
    },
};
</script>

<template>
    <AppLayout title="Créer un projet">
        <template #header>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Créer un projet</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <ApplicationLogo class="block h-12 w-auto" />

                        <h1 class="mt-8 text-2xl font-medium text-gray-900">Nouveau projet</h1>
                    </div>

                    <form @submit.prevent="createProject">
                        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-4">
                                    <label for="title" class="block font-medium text-sm text-gray-700">Titre</label>
                                    <input v-model="project.title" id="title" type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                </div>
                                <div class="col-span-6 sm:col-span-4">
                                    <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                                    <input v-model="project.description" id="description" type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                </div>
                            </div>
                            <div v-if="errorMessage" class="text-red-500">{{ errorMessage }}</div>
                            <div class="flex items-center justify-end px-4 py-3 text-end sm:px-6">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Sauvegarder</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <Footer />
    </AppLayout>
</template>