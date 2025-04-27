<script setup lang="ts">
import ApplicationButton from '@/Components/ApplicationButton.vue';
import ApplicationLoading from '@/Components/ApplicationLoading.vue';
import ApplicationPagination from '@/Components/ApplicationPagination.vue';
import ApplicationTable from '@/Components/ApplicationTable.vue';
import { useProducts } from '@/composables/useProducts';
import ProductModal from '@/Pages/Dashboard/components/ProductModal.vue';

const { loading, filters, products, pagination, pageChange, perPageChange, deleteProduct, deletingId } = useProducts();

const products_headers = ['id', 'name', 'description', 'quantity', 'price'];
</script>

<template>
    <ApplicationLoading :loading="loading">
        <ApplicationTable :headers="products_headers" :empty-message="filters.search ? 'No products found' : 'No products available'">
            <tr v-for="(item, index) in products" :key="index">
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
                        <ProductModal :product="item" />
                        <ApplicationButton
                            v-if="item.id"
                            variant="danger"
                            :rounded="true"
                            @click="deleteProduct(item.id)"
                            :disabled="deletingId === item.id"
                        >
                            {{ deletingId === item.id ? 'Deleting...' : 'Delete' }}
                        </ApplicationButton>
                    </div>
                </td>
            </tr>
        </ApplicationTable>
        <ApplicationPagination
            :pagination="pagination"
            @pageChange="(page) => pageChange(page)"
            @perPageChange="(perPage) => perPageChange(perPage)"
        />
    </ApplicationLoading>
</template>
