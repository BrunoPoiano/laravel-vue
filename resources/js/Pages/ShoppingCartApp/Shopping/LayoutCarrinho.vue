<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Carrinho
            </h2>
        </template>
        <div class="p-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <rotas />
        </div>
        <div class="mensagem" v-if="mensagem">
            {{ mensagem }}
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <carrinho @mensagem="exibirMensagem" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Rotas from "../Rotas.vue";
import Carrinho from "./Carrinho.vue";
import { ref } from "@vue/runtime-core";

export default {
    components: {
        AppLayout,
        Rotas,
        Carrinho,
    },
    setup() {
        const mensagem = ref();

        const exibirMensagem = (mens) => {
            mensagem.value = mens;
        };

        return { exibirMensagem, mensagem };
    },
};
</script>
