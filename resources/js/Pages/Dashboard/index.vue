<script setup lang="ts">
import Input from '@/Components/ApplicationForm/Input.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axiosInstance from '@/lib/axios';
import ProductModal from '@/Pages/Dashboard/components/ProductModal.vue';
import ProductTable from '@/Pages/Dashboard/components/ProductTable.vue';
import type { Pagination } from '@/types/pagination';
import type { Product } from '@/types/products';
import { debounce } from '@/utils/debounce';
import { IsNumberOrDefault, IsString } from '@/utils/typeFunctions';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref, watch } from 'vue';

const search = ref('');
const pagination = ref<Pagination | null>(null);
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
            const { data, meta } = response.data;

            pagination.value = {
                current_page: IsNumberOrDefault(meta.current_page, 1),
                from: IsNumberOrDefault(meta.from, 1),
                last_page: IsNumberOrDefault(meta.last_page, 1),
                per_page: IsNumberOrDefault(meta.per_page, 10),
                to: IsNumberOrDefault(meta.to, 1),
                total: IsNumberOrDefault(meta.total, 1),
            };
            products.value = data.map((product: Product) => ({
                id: IsNumberOrDefault(product.id, 0),
                name: IsString(product.name),
                description: IsString(product.description),
                quantity: IsNumberOrDefault(product.quantity, 0),
                price: IsNumberOrDefault(product.price, 0),
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
            <div class="flex justify-between">
                <h3 class="m-0">Products</h3>
                <ProductModal @refreshTable="getProducts" />
            </div>
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
