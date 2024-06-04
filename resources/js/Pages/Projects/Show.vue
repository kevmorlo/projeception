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
    };
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
                        <div class="py-4 flex justify-between items-center">
                            <!-- <span>{{ project['Title'] }}</span> -->
                            <span>Identifiant :{{ project['ID'] }}</span>
                            <Link :href="route('teams.show', project['TeamId'])">
                                <span>Equipe du projet :{{ project['Team'] }}</span>
                            </Link>
                            <span>{{ project['Description'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Footer />
        
    </AppLayout>
</template>