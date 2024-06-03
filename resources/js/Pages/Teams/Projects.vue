<script>
export default {
    data() {
        return {
            projects: this.$page.props.teamProjects,
        };
    },
};
</script>

<template>
    <div>
        <h1>Liste des projets de {{ $page.props.teamName }}</h1>
        <ul>
            <li v-for="project in projects" :key="project.id">
                <a :href="`/projects/${project.id}`">{{ project.name }}</a>
            </li>
        </ul>
    </div>
</template>