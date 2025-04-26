<template>
    <button
        :class="[
            'inline-flex cursor-pointer items-center justify-center border-none font-semibold transition-all duration-200',
            sizeClass,
            variantClass,
            { 'flex w-full': block, 'rounded-lg': rounded, 'cursor-not-allowed opacity-65': disabled },
        ]"
        :disabled="disabled"
        :type="type as ButtonHTMLAttributes['type']"
        @click="$emit('click', $event)"
    >
        <slot></slot>
    </button>
</template>

<script lang="ts">
import type { ButtonHTMLAttributes } from 'vue';

export default {
    name: 'GenericButton',
    props: {
        size: {
            type: String,
            default: 'md',
            validator: (value: unknown) => ['sm', 'md', 'lg'].includes(value as string),
        },
        variant: {
            type: String,
            default: 'primary',
            validator: (value: unknown) => ['primary', 'secondary', 'success', 'danger', 'warning', 'info'].includes(value as string),
        },
        block: {
            type: Boolean,
            default: false,
        },
        rounded: {
            type: Boolean,
            default: false,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        type: {
            type: String,
            default: 'button',
            validator: (value: ButtonHTMLAttributes['type']) => ['button', 'submit', 'reset'].includes(value as string),
        },
    },
    computed: {
        sizeClass(): string {
            switch (this.size) {
                case 'sm':
                    return 'py-1.5 px-3 text-sm';
                case 'lg':
                    return 'py-3 px-6 text-lg';
                default:
                    return 'py-2 px-4 text-base';
            }
        },
        variantClass() {
            switch (this.variant) {
                case 'primary':
                    return 'bg-blue-600 hover:bg-blue-700 text-white';
                case 'secondary':
                    return 'bg-gray-600 hover:bg-gray-700 text-white';
                case 'success':
                    return 'bg-green-500 hover:bg-green-600 text-white';
                case 'danger':
                    return 'bg-red-500 hover:bg-red-600 text-white';
                case 'warning':
                    return 'bg-yellow-500 hover:bg-yellow-600 text-white';
                case 'info':
                    return 'bg-blue-400 hover:bg-blue-500 text-white';
                default:
                    return 'bg-blue-600 hover:bg-blue-700 text-white';
            }
        },
    },
};
</script>
