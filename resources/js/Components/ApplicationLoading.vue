<script lang="ts">
export default {
    props: {
        loading: {
            type: Boolean,
            required: true,
            default: false,
        },
    },
};
</script>

<template>
    <div v-if="loading">
        <span>Loading...</span>
    </div>
    <div v-else>
        <slot></slot>
    </div>
</template>
