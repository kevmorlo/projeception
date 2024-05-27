<script setup>
    import ApplicationLogo from '@/Components/ApplicationLogo.vue';
    import axios from 'axios';
</script>

<template>
    <div>
        <h1>{{ project['Title'] }}</h1>
        <span>{{ project['ID'] }}</span>
        <span>{{ project['Description'] }}</span>
        <span>{{ project['Team'] }}</span>
    </div>
</template>

<script>

export default {
    data() {
        return {
            project: null,
        };
    },
    async created() {
        const projectId = this.$route.params.project;
        const response = await axios.get(`/projects/${projectId}`);
        this.project = response.data;
    },
};
</script>