<template>
    <div>
        <form @submit.prevent="updateProject">
            <div>
                <label for="name">Nom du projet:</label>
                <input type="text" id="name" v-model="project.name">
            </div>
            <div>
                <label for="description">Description:</label>
                <textarea id="description" v-model="project.description"></textarea>
            </div>
            <button type="submit">Mettre à jour</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            project: {
                name: '',
                description: ''
            }
        }
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