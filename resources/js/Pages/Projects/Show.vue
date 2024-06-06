<script>
    import { ref } from 'vue';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import ApplicationLogo from '@/Components/ApplicationLogo.vue';
    import Footer from '@/Components/Footer.vue';
    import Delete from './Delete.vue';
    import { Link } from '@inertiajs/vue3';

    export default {
        components: {
            AppLayout,
            ApplicationLogo,
            Footer,
            Link,
            Delete,
        },
        setup() {
            const errorMessage = ref(null);

            return {
                errorMessage,
            };
        },

        data() {
            return {
                project: this.$page.props.project,
                errorMessage: null,
            };
        },

        methods: {
            async updateProject() {
            try {
                await this.$inertia.put(`/projects/${this.project['Id']}`, 
                    {
                        title: this.project['Title'],
                        description: this.project['Description'],
                        status_id: this.project['StatusId'],
                    }
                ).then(({ props }) => {
                    if (props.info === 'Projet mis à jour avec succès.') {
                        this.$inertia.reload({ only: ['project'] });
                    } else {
                        this.errorMessage = 'Une erreur inattendue s\'est produite lors de la mise à jour.';
                    }
                });
            } catch (error) {
                errorMessage.value = 'Une erreur inattendue s\'est produite lors de la mise à jour.';
            }
        }
        },

        async created() {
            try {
                this.project = this.$page.props.project;
            } catch (error) {
                errorMessage.value = 'Une erreur inattendue s\'est produite lors de la récupération du projet.';
            }
        }
    }
</script>

<template>
    <AppLayout title="Projet">
        <template #header>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Projet</h2>
            </div>
        </template>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <ApplicationLogo class="block h-12 w-auto" />

                        <h1 class="mt-8 text-2xl font-medium text-gray-900">
                            {{ project['Title'] }}
                        </h1>
                    </div>
                    <form @submit="updateProject">
                        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-4">
                                    <label for="title" class="block font-medium text-sm text-gray-700">Titre</label>
                                    <input v-model="project['Title']" id="title" type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                </div>
                                <div class="col-span-6 sm:col-span-4">
                                    <label for="project-id" class="block font-medium text-sm text-gray-700">Identifiant</label>
                                    <input type="text" v-model="project['Id']" id="project-id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" disabled>
                                </div>
                                <div class="col-span-6 sm:col-span-4">
                                    <label class="block font-medium text-sm text-gray-700">Equipe</label>
                                    <Link :href="route('teams.show', project['TeamId'])" class="cursor-pointer">
                                        <button type="button" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-md mt-1 py-2 block w-full text-left transition-colors duration-200 hover:bg-gray-200">
                                            <span class="ml-2">{{ project['Team'] }}</span>
                                        </button>
                                    </Link>
                                </div>
                                <div class="col-span-6 sm:col-span-4">
                                    <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                                    <input v-model="project['Description']" id="description" type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                </div>
                                <div class="col-span-6 sm:col-span-4">
                                    <label for="status_id" class="block font-medium text-sm text-gray-700">Statut</label>
                                    <select v-model="project['StatusId']" id="status_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                        <option value="1">Privé</option>
                                        <option value="2">Public</option>
                                    </select>
                                </div>
                            </div>
                            <div v-if="errorMessage" class="text-red-500">{{ errorMessage }}</div>
                            <div class="flex items-center justify-end px-4 py-3 text-end sm:px-6">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Sauvegarder</button>
                            </div>
                        </div>
                    </form>
                    <Delete :project="project" />
                </div>
            </div>
        </div>

        <Footer />
        
    </AppLayout>
</template>