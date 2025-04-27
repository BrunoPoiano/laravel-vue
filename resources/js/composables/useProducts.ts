import { storeToRefs } from 'pinia'
import { useProductStore } from '@/stores/productStore'

export function useProducts() {
  const store = useProductStore()
  const { filteredProducts, loading, error, filters, paginationInfo, deletingId } = storeToRefs(store)

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
createProduct:store.createProduct,
editProduct:store.editProduct,
    resetFilters: store.resetFilters,

    pageChange: store.pageChange,
    perPageChange: store.perPageChange,
    setupWatcher:store.setupWatcher
  }
}
