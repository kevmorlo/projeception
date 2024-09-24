<script>
import { Link } from '@inertiajs/vue3';
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

    props: {
        teamProjects: Array,
        teamName: String,
    },

    setup(props) {
        return {
            projects: props.teamProjects,
            teamName: props.teamName,
        };
    },
};
</script>

<template>
    <AppLayout>
        <template #header>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $page.props.teamName }}</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <ApplicationLogo class="block h-12 w-auto" />
                        </div>
                        <h1 class="mt-8 text-2xl font-medium text-gray-900">
                            Projets de {{ $page.props.teamName }}
                        </h1>
                    </div>

                    <ul>
                        <li v-for="project in projects" :key="project.id" class="py-4 flex justify-between items-center">
                            <Link :href="route('projects.update', project.id)" class="flex items-center">
                                <h2 class="ml-4 text-sm font-medium text-gray-900">{{ project.title }}</h2>
                                <span class="ml-4 text-xs font-medium text-gray-900">{{ project.description }}</span>
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <Footer />
    </AppLayout>
</template>