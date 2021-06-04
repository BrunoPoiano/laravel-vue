<template>
    <div
        class="btn-group"
        role="group"
        aria-label="Basic radio toggle button group"
    >
        <div v-if="secao.length">
            <div v-for="sec in secao" :key="sec.id">
                <input
                    type="radio"
                    class="btn-check"
                    name="btnradio"
                    :id="sec.id"
                    autocomplete="off"
                    checked
                />
                <label
                    class="btn btn-outline-primary d-grid gap-2 mx-auto"
                    :for="sec.id"
                    @click="secaoConteudo(sec.id)"
                >
                    {{ sec.nome }}</label
                >
            </div>
        </div>
        <div v-else>
            <h1>carregando</h1>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import GetSecoes from "./Composables/GetSecoes.js";
export default {
    setup(props, context) {
        const { getsecoes, secao, errorSecao } = GetSecoes();
        getsecoes();

        const secaoConteudo = (id) => {
            context.emit('idsc', id)
        };

        return { secao, errorSecao, secaoConteudo };
    },
};
</script>

<style></style>
