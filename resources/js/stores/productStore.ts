import axiosInstance from '@/lib/axios';
import type { ProductFilters } from '@/types/filters';
import type { Pagination } from '@/types/pagination';
import type { Product } from '@/types/products';
import { debounce } from '@/utils/debounce';
import { IsNumberOrDefault, IsString } from '@/utils/typeFunctions';
import { defineStore } from 'pinia';
import { watch } from 'vue';

export const useProductStore = defineStore('products', {
    state: () => ({
        products: [] as Product[],
        loading: false,
        deletingId: null as number | null,
        error: null as string | null,
        filters: {
            search: '',
        } as ProductFilters,
        pagination: {
            currentPage: 1,
            from: 1,
            lastPage: 1,
            perPage: 10,
            to: 1,
            total: 1,
        } as Pagination,
        debouncedFetchProductsFn: null as null | (() => void),
    }),

    getters: {
        filteredProducts: (state) => state.products,
        hasErrors: (state) => state.error !== null,
        filtersInfo: (state) => ({
            search: state.filters.search,
        }),
        paginationInfo: (state) => ({
            perPage: state.pagination.perPage,
            currentPage: state.pagination.currentPage,
            from: state.pagination.from,
            lastPage: state.pagination.lastPage,
            to: state.pagination.to,
            total: state.pagination.total,
        }),
    },

    actions: {
        async fetchProducts() {
            this.loading = true;
            this.error = null;

            try {
                const { data } = await axiosInstance.get('products/list', {
                    params: {
                        ...this.filters,
                        per_page: this.pagination.perPage,
                        current_page: this.pagination.currentPage,
                    },
                });

                this.products = data.data.map((product: Product) => ({
                    id: IsNumberOrDefault(product.id, 0),
                    name: IsString(product.name),
                    description: IsString(product.description),
                    quantity: IsNumberOrDefault(product.quantity, 0),
                    price: IsNumberOrDefault(product.price, 0),
                }));

                this.pagination = {
                    currentPage: IsNumberOrDefault(data.meta.current_page, 1),
                    from: IsNumberOrDefault(data.meta.from, 1),
                    lastPage: IsNumberOrDefault(data.meta.last_page, 1),
                    perPage: IsNumberOrDefault(data.meta.per_page, 10),
                    to: IsNumberOrDefault(data.meta.to, 1),
                    total: IsNumberOrDefault(data.meta.total, 1),
                };
            } catch (error) {
                this.error = 'Failed to fetch products';
                console.error(error);
            } finally {
                this.loading = false;
            }
        },

        debouncedFetchProducts() {
            console.log('debouncedFetchProducts');
            debounce(() => this.fetchProducts(), 800);
        },

        pageChange(page: number) {
            this.pagination.currentPage = page;
            this.fetchProducts();
        },

        perPageChange(perPage: number) {
            this.pagination.perPage = perPage;
            this.fetchProducts();
        },

        async deleteProduct(product_id: number): Promise<void> {
            return await new Promise((resolve, reject) => {
                if (!product_id || this.deletingId === product_id) return;
                this.deletingId = product_id;
                try {
                    axiosInstance.delete(`products/${product_id}`);
                    this.fetchProducts();
                    resolve();
                } catch (error) {
                    this.error = 'Failed to Delete products';
                    console.error(error);
                    reject(error);
                } finally {
                    this.deletingId = null;
                }
            });
        },

        async createProduct(product: Product): Promise<void> {
            return await new Promise((resolve, reject) => {
                try {
                    axiosInstance.post('products', product);
                    this.fetchProducts();
                    resolve();
                } catch (error) {
                    this.error = 'Failed to Create products';
                    console.error(error);
                    reject(error);
                }
            });
        },

        async editProduct(product: Product, product_id: number): Promise<void> {
            return await new Promise((resolve, reject) => {
                try {
                    axiosInstance.put(`products/${product_id}`, product);
                    this.fetchProducts();
                    resolve();
                } catch (error) {
                    this.error = 'Failed to Edit products';
                    console.error(error);
                    reject(error);
                }
            });
        },

        resetFilters() {
            this.filters = {
                search: '',
            };
            this.fetchProducts();
        },

        updateFilters(filters: unknown) {
            const filtersObj = (filters as Record<string, unknown>) || {};

            this.filters = {
                search: IsString(filtersObj.search, ''),
            };
        },

        updateProducts(products: unknown[]) {
            if (!Array.isArray(products)) {
                // this.fetchProducts();
                return;
            }

            const parsedProducts: Product[] = products.map((item: unknown) => {
                const productItem = item as Record<string, unknown>;
                return {
                    id: IsNumberOrDefault(productItem?.id, 0),
                    name: IsString(productItem?.name, ''),
                    description: IsString(productItem?.description, ''),
                    price: IsNumberOrDefault(productItem?.price, 0),
                    quantity: IsNumberOrDefault(productItem?.quantity, 0),
                };
            });

            this.products = parsedProducts;
        },

        updatePagination(pagination: unknown) {
            const paginationObj = (pagination as Record<string, unknown>) || {};

            this.pagination = {
                from: IsNumberOrDefault(paginationObj.from as number, 1),
                lastPage: IsNumberOrDefault(paginationObj.last_page as number, 1),
                to: IsNumberOrDefault(paginationObj.to as number, 1),
                total: IsNumberOrDefault(paginationObj.total as number, 1),
                currentPage: IsNumberOrDefault(paginationObj.current_page as number, 1),
                perPage: IsNumberOrDefault(paginationObj.per_page as number, 10),
            };
        },

        setupWatcher() {
            if (!this.debouncedFetchProductsFn) {
                this.debouncedFetchProductsFn = debounce(() => this.fetchProducts(), 800);
            }

            watch(
                () => this.filters.search,
                () => {
                    if (this.debouncedFetchProductsFn) {
                        this.debouncedFetchProductsFn();
                    }
                },
            );
        },
    },
});
