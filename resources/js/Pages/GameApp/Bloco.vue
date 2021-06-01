<template>
    <div class="bloco" v-if="mostrarBloco" @click="parartimer">clique em mim</div>
</template>

<script>
import { onMounted, ref } from "vue";
export default {
    props: ["delay"],
    setup(props, context) {
        const mostrarBloco = ref(false);
        const tempo = ref(null);
        const tempoReacao = ref(0);

        onMounted(() => {
            setTimeout(() => {
                mostrarBloco.value = true;
                console.log("delay", props.delay);
                comecartimer();
            }, props.delay);
        });

        const comecartimer = () => {
            tempo.value = setInterval(() => {
                tempoReacao.value += 10;
            }, 10);
        };

        const parartimer = () => {
            clearInterval(tempo);
            //console.log('tempoReacao' , tempoReacao.value);
            context.emit("end", tempoReacao.value);
        };

        return {
            mostrarBloco,
            tempo,
            tempoReacao,
            parartimer,
        };
    },
};
</script>

<style>
.bloco {
    width: 400px;
    border-radius: 20px;
    background: rgb(171, 26, 238);
    color: white;
    text-align: center;
    padding: 100px 0;
    margin: 40px auto;
}
</style>
