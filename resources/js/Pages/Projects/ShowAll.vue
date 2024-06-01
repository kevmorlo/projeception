<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const projects = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get('/projects');
        projects.value = response.data;
    } catch (error) {
        console.error(error);
    }
});
</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
            <ApplicationLogo class="block h-12 w-auto" />

            <h1 class="mt-8 text-2xl font-medium text-gray-900">
                Projets
            </h1>

            <p class="mt-6 text-gray-500 leading-relaxed">
                Liste de tous les projets
            </p>

            <div>
                <div class="mt-6">
                    <ul class="divide-y divide-gray-200">
                        <li v-for="project in projects" :key="project.id" class="py-4 flex justify-between items-center">
                            <div class="flex items-center">
                                <h2 class="ml-4 text-sm font-medium text-gray-900">{{ project['Title'] }}</h2>
                                <span class="ml-4 text-xs font-medium text-gray-900">{{ project['ID'] }}</span>
                                <span class="ml-4 text-xs font-medium text-gray-900">{{ project['Description'] }}</span>
                                <span class="ml-4 text-xs font-medium text-gray-900">{{ project['Team'] }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>