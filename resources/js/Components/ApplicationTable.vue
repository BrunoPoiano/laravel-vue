<script lang="ts">
export default {
    props: {
        content: {
            type: Array,
            default: null,
        },
        headers: {
            type: Array,
            required: true,
        },
        emptyMessage: {
            type: String,
            default: 'No content',
        },
    },
};
</script>

<template>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th
                    v-for="value in headers"
                    :key="value as string"
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                >
                    {{ value }}
                </th>
            </tr>
        </thead>
        <tbody v-if="content === null" class="divide-y divide-gray-200 bg-white">
            <slot />
        </tbody>

        <tbody v-else-if="content.length === 0" class="divide-y divide-gray-200 bg-white">
            <tr>
                <td class="whitespace-nowrap px-6 py-4">{{ emptyMessage }}</td>
            </tr>
        </tbody>

        <tbody v-else class="divide-y divide-gray-200 bg-white">
            <tr v-for="(item, index) in content" :key="index">
                <td v-for="(t, index) in item" :key="index" class="whitespace-nowrap px-6 py-4">{{ t }}</td>
            </tr>
        </tbody>
    </table>
</template>
