<template>
    <div class="container p-2">
        <button @click="start" :disabled="jogando">Iniciar</button>
        <bloco v-if="jogando" :delay="delay" @end="endgame" />
        <resultado v-if="mostrarResultado" :pontuacao="pontuacao" />
    </div>
</template>

<script>
import { ref } from "vue";

import Bloco from "./Bloco.vue";
import Resultado from "./Resultado.vue";
export default {
    components: { Resultado, Bloco },

    setup() {
        const jogando = ref(false);
        const delay = ref(null);
        const pontuacao = ref(null);
        const mostrarResultado = ref(false);

        const start = () => {
            delay.value = 2000 + Math.random() * 2000;
            jogando.value = true;
            mostrarResultado.value = false;
        };

        const endgame = (temporeacao) => {
            console.log(temporeacao);
            pontuacao.value = temporeacao;
            jogando.value = false;
            mostrarResultado.value = true;
        };

        return { start, jogando, delay, pontuacao, mostrarResultado, endgame };
    },
};
</script>

<style>
button {
    background: #0faf87;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    font-size: 16px;
    letter-spacing: 1px;
    cursor: pointer;
    margin: 10px;
}
button[disabled] {
    opacity: 0.2;
    cursor: not-allowed;
}
</style>
