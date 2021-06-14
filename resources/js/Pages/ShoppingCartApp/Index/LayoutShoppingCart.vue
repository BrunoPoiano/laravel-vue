<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Shopping Cart App
            </h2>
        </template>
        <div class="p-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <rotas />
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                   <get-produtos />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Rotas from "../Rotas.vue";
import GetProdutos from './GetProdutos.vue'

export default {
    components: {
        AppLayout,
        Rotas,
        GetProdutos
    },
};
</script>
