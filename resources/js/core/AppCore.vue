<template>
    <div id="app" class="flex h-screen">
        <Sidebar />
        <div class="flex-1 overflow-y-auto">
            <router-view />
        </div>
    </div>
</template>

<script setup>
import Sidebar from "../components/SideBar.vue";
</script>

<style>
/* Add any global styles here if needed */
</style>
