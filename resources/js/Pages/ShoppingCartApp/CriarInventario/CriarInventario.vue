<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Criar Inventario
            </h2>
        </template>
        <div class="p-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <rotas />
        </div>
        <div v-if="mensagem">
            <h1 class="text-capitalize fw-bold mensagem">{{ mensagem }}</h1>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <inventario-form @mensagem="exibirMensagem" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Rotas from "../Rotas.vue";
import InventarioForm from "./InventarioForm.vue";
import { ref } from "vue";

export default {
    components: {
        AppLayout,
        Rotas,
        InventarioForm,
    },
    setup() {
        const mensagem = ref();

        const exibirMensagem = (men) => {
            mensagem.value = men;
        };

        return {
            exibirMensagem,
            mensagem,
        };
    },
};
</script>

<style>
.mensagem {
    font-size: 2rem;
}
</style>
