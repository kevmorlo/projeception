<script>
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
        data() {
            return {
                project: this.$page.props.project,
            };
        },
        methods: {
            async updateProject() {
            try {
                const response = await this.$inertia.get(`/projects/${this.project['Id']}`);
                this.$router.push(`/projects/${this.project['Id']}`);
            } catch (error) {
                console.error(error);
            }
        }
        },
        async created() {
            try {
                await this.$inertia.get(`/projects/${this.project['Id']}`);
                this.project = this.$page.props.project;
            } catch (error) {
                console.error(error);
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
                                    <label for="id" class="block font-medium text-sm text-gray-700">Identifiant</label>
                                    <input type="text" :value="project['Id']" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" disabled>
                                </div>
                                <div class="col-span-6 sm:col-span-4">
                                    <label for="team" class="block font-medium text-sm text-gray-700">Equipe</label>
                                    <Link :href="route('teams.show', project['TeamId'])">
                                        <input v-model="project['Team']" id="team" type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                    </Link>
                                </div>
                                <div class="col-span-6 sm:col-span-4">
                                    <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                                    <input v-model="project['Description']" id="description" type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                </div>
                            </div>
                            <div v-if="errorMessage" class="text-red-500">{{ errorMessage }}</div>
                            <div class="flex items-center justify-end px-4 py-3 text-end sm:px-6">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Sauvegarder</button>
                            </div>
                        </div>
                    </form>
                    <Delete />
                </div>
            </div>
        </div>

        <Footer />
        
    </AppLayout>
</template>