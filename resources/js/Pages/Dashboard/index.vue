<script setup lang="ts">
import Input from '@/Components/ApplicationForm/Input.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axiosInstance from '@/lib/axios';
import ProductModal from '@/Pages/Dashboard/components/ProductModal.vue';
import ProductTable from '@/Pages/Dashboard/components/ProductTable.vue';
import type { Pagination } from '@/types/pagination';
import type { Product } from '@/types/products';
import { debounce } from '@/utils/debounce';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref, watch } from 'vue';

const search = ref('');
const pagination = ref<Pagination>();
const products = ref([]);
const loading = ref<boolean>(false);

const pageChange = (page: number) => {
    if (pagination.value) {
        pagination.value.current_page = page;
        getProducts();
    }
};

const perPageChange = (perPage: number) => {
    if (pagination.value) {
        pagination.value.per_page = perPage;
        getProducts();
    }
};

const getProducts = () => {
    loading.value = true;
    axiosInstance
        .get('products', {
            params: {
                search: search.value,
                per_page: pagination.value?.per_page,
                current_page: pagination.value?.current_page,
            },
        })
        .then((response) => {
            const { data, ...pagination_data } = response.data;

            pagination.value = pagination_data;
            products.value = data.map((product: Product) => ({
                id: product.id,
                name: product.name,
                description: product.description,
                quantity: product.quantity,
                price: `$ ${product.price}`,
            }));
        })
        .catch((error) => {
            console.error(error);
        })
        .finally(() => {
            loading.value = false;
        });
};

const debouncedGetProducts = debounce(() => getProducts(), 800);

watch(search, () => {
    debouncedGetProducts();
});

onMounted(() => {
    getProducts();
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h3 class="m-0">Products</h3>
            <ProductModal />
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white p-5 shadow-sm sm:rounded-lg">
                    <div class="">
                        <Input type="text" placeholder="Search" v-model="search" />
                        <ProductTable
                            :loading="loading"
                            :products="products"
                            :pagination="pagination"
                            :search="search"
                            @pageChange="pageChange"
                            @perPageChange="perPageChange"
                            @refreshTable="getProducts"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
