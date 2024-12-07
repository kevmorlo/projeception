<script>
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
        project: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            showModal: false,
        };
    },
    methods: {
        showConfirmationModal() {
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
        deleteProject() {
            axios.delete(`/projects/${this.project['Id']}`)
                .then(response => {
                    if (response.data.info === 'Projet supprimé avec succès.') {
                        Inertia.visit('/projects');
                    } else {
                        console.error("Une erreur s'est produite lors de la suppression du projet");
                        this.closeModal();
                    }
                })
                .catch(error => {
                    console.error("Une erreur s'est produite lors de la suppression du projet", error);
                });
        }
    }
};
</script>

<template>
    <div>
        <button @click="showConfirmationModal" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 m-10 float-right">Supprimer le projet</button>
        
        <div v-if="showModal">
            <div class="bg-white p-5 rounded shadow-md">
                <h2 class="font-semibold text-center text-xl text-gray-800 leading-tight">Confirmation de suppression</h2>
                <p class="text-center">Êtes-vous sûr de vouloir supprimer ce projet ?</p>
                <div class="flex flex-row justify-around px-6 py-4 text-end">
                    <button @click="deleteProject" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">Supprimer</button>
                    <button @click="closeModal" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">Annuler</button>
                </div>
            </div>
        </div>
    </div>
</template>