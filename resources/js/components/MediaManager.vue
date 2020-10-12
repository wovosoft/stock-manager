<template>
    <file-manager style="min-height: 80vh"></file-manager>
</template>

<script>
    import store from '@/laravel-file-manager/src/store';
    import FileManager from '@/laravel-file-manager/src/FileManager.vue';
    import app_store from "@/shared/store"

    app_store.registerModule('fm', store);

    export default {
        name: "MediaManager",
        components: {
            FileManager
        }
    }
</script>

<style scoped>

</style>
