<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionSection from '@/Components/ActionSection.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    team: Object,
});

const confirmingTeamDeletion = ref(false);
const form = useForm({});

const confirmTeamDeletion = () => {
    confirmingTeamDeletion.value = true;
};

const deleteTeam = () => {
    form.delete(route('teams.destroy', props.team), {
        errorBag: 'deleteTeam',
    });
};
</script>

<template>
    <ActionSection>
        <template #title>
            Supprimer l'équipe
        </template>

        <template #description>
            Supprimer définitivement cette équipe.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Une fois l'équipe supprimée, toutes ces données seront perdues. Avant de la supprimer, veuillez télécharger toute donnée que vous souhaitez concerver concernant cette équipe.
            </div>

            <div class="mt-5">
                <DangerButton @click="confirmTeamDeletion">
                    Supprimer l'équipe
                </DangerButton>
            </div>

            <!-- Supprimer l'équipe Confirmation Modal -->
            <ConfirmationModal :show="confirmingTeamDeletion" @close="confirmingTeamDeletion = false">
                <template #title>
                    Supprimer l'équipe
                </template>

                <template #content>
                    Êtes vous sûr de vouloir supprimer cette équipe? Une fois supprimée, toutes ces données seront perdues.
                </template>

                <template #footer>
                    <SecondaryButton @click="confirmingTeamDeletion = false">
                        Annuler
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteTeam"
                    >
                        Supprimer l'équipe
                    </DangerButton>
                </template>
            </ConfirmationModal>
        </template>
    </ActionSection>
</template>
