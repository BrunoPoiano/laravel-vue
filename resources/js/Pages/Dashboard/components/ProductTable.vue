<script setup lang="ts">
import ApplicationButton from '@/Components/ApplicationButton.vue';
import ApplicationLoading from '@/Components/ApplicationLoading.vue';
import ApplicationPagination from '@/Components/ApplicationPagination.vue';
import ApplicationTable from '@/Components/ApplicationTable.vue';
import axiosInstance from '@/lib/axios';
import ProductModal from '@/Pages/Dashboard/components/ProductModal.vue';
import type { Pagination } from '@/types/pagination';
import type { Product } from '@/types/products';
import { ref } from 'vue';

const emit = defineEmits(['refreshTable', 'pageChange', 'perPageChange']);
const props = defineProps({
    loading: {
        type: Boolean,
        default: false,
    },
    products: {
        type: Array as () => Product[],
        required: true,
    },
    pagination: {
        type: Object as () => Pagination | null,
        default: null,
    },
    search: {
        type: String,
        default: '',
    },
});

const products_headers = ['id', 'name', 'description', 'quantity', 'price'];
const deletingId = ref<number | null>(null);

const deleteProduct = (product: Product) => {
    if (!product.id || deletingId.value === product.id) return;

    deletingId.value = product.id;

    axiosInstance
        .delete(`products/${product.id}`)
        .then(() => {
            emit('refreshTable');
        })
        .catch((error) => {
            console.error(error);
        })
        .finally(() => {
            deletingId.value = null;
        });
};
</script>

<template>
    <ApplicationLoading :loading="props.loading">
        <ApplicationTable :headers="products_headers" :empty-message="search ? 'No products found' : 'No products available'">
            <tr v-for="(item, index) in props.products" :key="index">
                <td class="whitespace-nowrap px-6 py-4">
                    {{ item.id }}
                </td>
                <td class="whitespace-nowrap px-6 py-4">
                    {{ item.name }}
                </td>
                <td class="whitespace-nowrap px-6 py-4">
                    {{ item.description }}
                </td>
                <td class="whitespace-nowrap px-6 py-4">
                    {{ item.quantity }}
                </td>
                <td class="whitespace-nowrap px-6 py-4">$ {{ item.price }}</td>
                <td>
                    <div class="flex gap-5">
                        <ProductModal :product="item as Product" />
                        <ApplicationButton
                            variant="danger"
                            :rounded="true"
                            @click.prevent="deleteProduct(item as Product)"
                            :disabled="deletingId === (item as Product).id"
                        >
                            {{ deletingId === (item as Product).id ? 'Deleting...' : 'Delete' }}
                        </ApplicationButton>
                    </div>
                </td>
            </tr>
        </ApplicationTable>
        <ApplicationPagination
            v-if="props.pagination"
            :pagination="props.pagination as Pagination"
            @pageChange="(page) => $emit('pageChange', page)"
            @perPageChange="(perPage) => $emit('perPageChange', perPage)"
        />
    </ApplicationLoading>
</template>
