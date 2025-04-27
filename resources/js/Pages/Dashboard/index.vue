<script setup lang="ts">
import Input from '@/Components/ApplicationForm/Input.vue';
import { useProducts } from '@/composables/useProducts';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProductModal from '@/Pages/Dashboard/components/ProductModal.vue';
import ProductTable from '@/Pages/Dashboard/components/ProductTable.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const { error, filters, fetchProducts, setupWatcher } = useProducts();

onMounted(() => {
    setupWatcher();
    fetchProducts();
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h3 class="m-0">Products</h3>
                <ProductModal />
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white p-5 shadow-sm sm:rounded-lg">
                    <div v-if="error" class="error">{{ error }}</div>
                    <div class="">
                        <Input type="text" placeholder="Search" v-model="filters.search" />
                        <ProductTable />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
