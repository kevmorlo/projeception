
<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Footer from '@/Components/Footer.vue';

export default {
    props: {
        logs: {
            type: Array,
            required: true
        }
    },

    components: {
        AppLayout,
        ApplicationLogo,
        Footer
    },
}
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
                        <div class="flex justify-between items-center">
                            <ApplicationLogo class="block h-12 w-auto" />
                        </div>
                        <h1 class="mt-8 text-2xl font-medium text-gray-900">
                            Logs des projets
                        </h1>
                    </div>

                    <ul>
                        <li v-for="log in logs" :key="log.id">
                            {{ log.content }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <Footer />
        
    </AppLayout>
</template>