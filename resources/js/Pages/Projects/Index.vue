<script>
import { usePage, Link } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Footer from '@/Components/Footer.vue';

export default {
    components: {
        AppLayout,
        ApplicationLogo,
        Link,
        Footer,
    },
    setup() {
        const { projects } = usePage().props;

        return {
            projects,
        };
    },
};
</script>

<template>
    <AppLayout title="Projets">
        <template #header>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Projets</h2>
            </div>
        </template>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <ApplicationLogo class="block h-12 w-auto" />

                        <h1 class="mt-8 text-2xl font-medium text-gray-900">
                            Découvrez les projets proposés par les apprenants !
                        </h1>
                        
                        <ul>
                            <li v-for="project in projects" :key="project.id" class="py-4 flex justify-between items-center">
                                <Link :href="route('projects.show', project.id)" class="flex items-center">
                                    <h2 class="ml-4 text-sm font-medium text-gray-900">{{ project['Title'] }}</h2>
                                    <span class="ml-4 text-xs font-medium text-gray-900">{{ project['Team'] }}</span>
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <Footer />

    </AppLayout>
</template>