<script setup lang="ts">
import ApplicationButton from '@/Components/ApplicationButton.vue';
import Input from '@/Components/ApplicationForm/Input.vue';
import Modal from '@/Components/Modal.vue';
import { useProducts } from '@/composables/useProducts';
import type { Product } from '@/types/products';
import { IsNumberOrDefault, IsString } from '@/utils/typeFunctions';
import { ref } from 'vue';

const { createProduct, editProduct } = useProducts();

const openModal = ref<boolean>(false);
const product_value = ref<Product>({
    name: '',
    description: '',
    price: 0,
    quantity: 0,
});

const props = defineProps({
    product: {
        type: Object as () => Product | null,
        default: null,
    },
});

/**
 * Toggles the modal visibility and initializes form data if opening with a product
 * @param value Boolean indicating whether to open (true) or close (false) the modal
 */
const toggleModal = (value: boolean) => {
    if (value && props.product) {
        product_value.value = {
            id: IsNumberOrDefault(props.product.id, 0),
            name: IsString(props.product.name),
            description: IsString(props.product.description),
            price: IsNumberOrDefault(props.product.price, 0),
            quantity: IsNumberOrDefault(props.product.quantity, 0),
        };
    }

    openModal.value = value;
};

/**
 * Handles form submission for creating or editing products
 * Validates and processes form data before making API request
 * @param e Form submission event
 */
const sendForm = (e: Event) => {
    const formData = new FormData(e.target as HTMLFormElement);
    const formObject = Object.fromEntries(formData);

    product_value.value = {
        name: IsString(formObject.name),
        description: IsString(formObject.description),
        price: IsNumberOrDefault(formObject.price, 0),
        quantity: IsNumberOrDefault(formObject.quantity, 0),
    };

    if (props.product?.id) {
        editProduct(product_value.value, props.product.id)
            .then(() => {
                toggleModal(false);
            })
            .catch((error) => {
                console.error('Error editing product:', error);
            });
    } else {
        createProduct(product_value.value)
            .then(() => {
                toggleModal(false);
            })
            .catch((error) => {
                console.error('Error creating product:', error);
            });
    }
};
</script>

<template>
    <ApplicationButton @click="toggleModal(true)" :rounded="true" :variant="product ? 'primary' : 'success'">
        {{ product ? 'Edit Product' : 'New Product' }}
    </ApplicationButton>

    <Modal :show="openModal" maxWidth="md" @close="toggleModal(false)">
        <div class="grid place-items-center gap-5 p-5">
            <h4>{{ product ? 'Edit Product' : 'New Product' }}</h4>
            <form class="grid w-full" v-on:submit.prevent="sendForm" id="testForm">
                <Input type="text" placeholder="Name" name="name" label="Name" v-model="product_value.name" required />
                <Input type="text" placeholder="Description" name="description" label="Description" v-model="product_value.description" />
                <Input type="number" placeholder="Price" name="price" label="Price" v-model="product_value.price" required />
                <Input type="number" placeholder="Quantity" name="quantity" label="Quantity" v-model="product_value.quantity" required />

                <div class="flex justify-end gap-5">
                    <ApplicationButton type="submit" :rounded="true" variant="success">Enviar</ApplicationButton>
                    <ApplicationButton type="button" :rounded="true" variant="danger" @click.prevent="toggleModal(false)">Close</ApplicationButton>
                </div>
            </form>
            <div class="flex w-full justify-end"></div>
        </div>
    </Modal>
</template>
