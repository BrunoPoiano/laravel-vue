<script setup lang="ts">
import Input from '@/Components/ApplicationForm/Input.vue';
import { useProducts } from '@/composables/useProducts';
import { onMounted } from 'vue';

const { filters, setupWatcher } = useProducts();

/**
 * Sets up watchers for reactive search functionality
 * Called when component is mounted
 */
onMounted(() => {
    setupWatcher();
});
</script>

<template>
    <Input type="text" placeholder="Search" v-model="filters.search" />
</template>
