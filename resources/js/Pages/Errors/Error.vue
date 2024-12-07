<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import Footer from '@/Components/Footer.vue';

export default {
    components: {
        AppLayout,
        Footer,
    },
    props: ['code', 'message'],
    methods: {
        goBack() {
            this.$inertia.visit(window.history.state.url);
        }
    }
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
                        <ApplicationLogo class="block h-12 w-auto" />

                        <h1 class="mt-8 text-2xl font-medium text-gray-900">Erreur {{ code }}</h1>
                        <p>{{ message }}</p>
                        <button @click="goBack">Retour à la page précédente</button>
                    </div>
                </div>
            </div>
        </div>

        <Footer />
    </AppLayout>
</template>
