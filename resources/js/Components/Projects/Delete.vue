<template>
    <div>
        <button @click="deleteProject">Supprimer le projet</button>
    </div>
</template>

<script>
export default {
    props: {
        projectId: {
            type: String,
            required: true
        }
    },
    methods: {
        async deleteProject() {
            try {
                let response = await this.$axios.delete(`/api/projects/${this.projectId}`);
                if (response.status === 200) {
                    this.$emit('projectDeleted', this.projectId);
                    this.$notify({
                        title: 'Succès',
                        message: 'Projet supprimé avec succès',
                        type: 'success'
                    });
                }
            } catch (error) {
                this.$notify({
                    title: 'Erreur',
                    message: 'Une erreur s\'est produite lors de la suppression du projet',
                    type: 'error'
                });
            }
        }
    }
}
</script>