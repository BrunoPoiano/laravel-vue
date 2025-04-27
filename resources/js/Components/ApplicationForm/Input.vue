<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
    name: 'GenericInput',
    props: {
        modelValue: {
            type: [String, Number],
            default: '',
        },
        type: {
            type: String,
            default: 'text',
        },
        name: {
            type: String,
            default: '',
        },
        placeholder: {
            type: String,
            default: '',
        },
        label: {
            type: String,
            default: '',
        },
        required: {
            type: Boolean,
            default: false,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        class: {
            type: String,
            default: 'mb-5 rounded-lg',
        },
    },
    emits: ['update:modelValue'],
});
</script>

<template>
    <div class="grid w-full">
        <label class="-mb-0.5 font-bold" v-if="label" :for="label">{{ label }}</label>
        <input
            :id="label"
            :type="type"
            :value="modelValue"
            :placeholder="placeholder"
            :required="required"
            :name="name"
            :disabled="disabled"
            :class="class"
            @input="$emit('update:modelValue', ($event.target as HTMLInputElement)?.value || '')"
        />
    </div>
</template>

<style scoped>
input {
    padding: 0.5rem;
    border: 1px solid #ccc;
    transition: border-color 0.2s;
}

input:focus {
    outline: none;
    border-color: #4f46e5;
}

input:disabled {
    background-color: #f3f4f6;
    cursor: not-allowed;
}
</style>
