<script setup>
import { ref, onMounted} from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import { marked } from 'marked';
import AppLayout from '@/Layouts/AppLayout.vue';
import Footer from '@/Components/Footer.vue';

const props = defineProps({
    terms: String,
});

const htmlTerms = ref('');

onMounted(() => {
    htmlTerms.value = marked(props.terms);
});
</script>

<template>
    <AppLayout title="Mentions Légales">
        <template #header>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mentions Légales</h2>
            </div>
        </template>
        <div class="font-sans text-gray-900 antialiased">
            <div class="pt-4 bg-gray-100">
                <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                    <div>
                        <AuthenticationCardLogo />
                    </div>

                    <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose" v-html="htmlTerms" />
                </div>
            </div>
        </div>

        <Footer /> 
    </AppLayout>
</template>
