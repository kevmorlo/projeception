<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import ApplicationLogo from '@/Components/ApplicationLogo.vue';
    import Footer from '@/Components/Footer.vue';
    import { Link } from '@inertiajs/vue3';

    export default {
        components: {
            AppLayout,
            ApplicationLogo,
            Footer,
            Link,
        },
        data() {
            return {
                project: this.$page.props.project,
            };
        },
        methods: {
                async updateProject() {
                try {
                    const response = await axios.put(`/projects/${this.project.id}`, this.project);
                    this.$router.push(`/projects/${this.project.id}`);
                } catch (error) {
                    console.error(error);
                }
            }
        },
        async created() {
            try {
                const response = await axios.get(`/projects/${this.$route.params.id}`);
                this.project = response.data;
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
                        <form @submit="updateProject">
                            <div class="py-4 flex justify-between items-center">
                                <label for="title">Titre</label>
                                <input v-model="project['Title']" id="title" type="text" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <label for="id">Identifiant</label>
                                <span id="id">{{ project['ID'] }}</span>
                                <label for="team">Equipe</label>
                                <Link :href="route('teams.show', project['TeamId'])">
                                    <input v-model="project['Team']" id="team" type="text" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                </Link>
                                <label for="description">Description</label>
                                <input v-model="project['Description']" id="description" type="text" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <Footer />
        
    </AppLayout>
</template>