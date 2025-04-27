<script lang="ts">
import type { Pagination } from '@/types/pagination';
export default {
    props: {
        pagination: {
            required: true,
            type: Object as () => Pagination,
        },
    },
    data() {
        return {
            perPage: 10,
        };
    },
    created() {
        if (this.pagination?.perPage) {
            this.perPage = this.pagination.perPage;
        }
    },
    computed: {
        perPageOptions() {
            return [
                {
                    text: '5 per page',
                    value: 5,
                },
                {
                    text: '10 per page',
                    value: 10,
                },
                {
                    text: '25 per page',
                    value: 25,
                },
                {
                    text: '50 per page',
                    value: 50,
                },
            ];
        },
    },
    methods: {
        currentPageChange(data: number) {
            this.$emit('pageChange', data);
        },
        perPageChange() {
            this.$emit('perPageChange', this.perPage);
        },
    },
    watch: {
        'pagination.lastPage': {
            handler() {
                if (this.pagination && this.pagination.currentPage > this.pagination.lastPage) {
                    this.$emit('pageChange', this.pagination.lastPage);
                }
            },
        },
        'pagination.per_page': {
            immediate: true,
            handler(newValue) {
                if (newValue) {
                    this.perPage = newValue;
                }
            },
        },
    },
};
</script>

<template>
    <div class="my-12 flex flex-col justify-center gap-1 px-5">
        <div class="flex justify-center gap-5 align-middle">
            <a href="#" @click="currentPageChange(pagination.currentPage - 1)"> < </a>
            <a v-for="(_, index) of pagination.lastPage" :key="index" href="#" @click="currentPageChange(index + 1)">
                <i class="fas fa-chevron-left">{{ index + 1 }}</i>
            </a>
            <a href="#" @click="currentPageChange(pagination.currentPage + 1)"> > </a>
        </div>
        <div class="flex flex-wrap items-center justify-between gap-2.5">
            <div class="flex-grow">
                <span class="text-sm font-normal leading-[17px] text-[#32363a]">
                    Showing from {{ pagination.from }}° to {{ pagination.to }}° of {{ pagination.total }} items
                </span>
            </div>
            <div class="mt-5">
                <select
                    v-model="perPage"
                    label="Items per page"
                    @change="perPageChange"
                    class="bg-white text-sm font-normal leading-[17px] text-[rgba(0,0,0,0.87)]"
                >
                    <option v-for="(option, index) in perPageOptions" :key="`${option.value}-${index}`" :value="option.value">
                        {{ option.text }}
                    </option>
                </select>
            </div>
        </div>
    </div>
</template>
