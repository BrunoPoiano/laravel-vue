import { useProductStore } from '@/stores/productStore';
import { storeToRefs } from 'pinia';

export function useProducts() {
    const store = useProductStore();
    const { filteredProducts, loading, error, filters, paginationInfo, deletingId } = storeToRefs(store);

    return {
        // State
        products: filteredProducts,
        loading,
        error,
        filters,
        pagination: paginationInfo,
        deletingId,

        // Actions
        fetchProducts: store.fetchProducts,
        deleteProduct: store.deleteProduct,
        createProduct: store.createProduct,
        editProduct: store.editProduct,
        resetFilters: store.resetFilters,

        updateFilters: store.updateFilters,
        updateProducts: store.updateProducts,
        updatePagination: store.updatePagination,

        pageChange: store.pageChange,
        perPageChange: store.perPageChange,
        setupWatcher: store.setupWatcher,
    };
}
