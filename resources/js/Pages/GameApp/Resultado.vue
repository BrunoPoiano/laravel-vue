<template>
    <h1 class="titulo">{{ titulo }}</h1>
    <h1 class="rank">{{ pontuacao }} Ms</h1>
</template>

<script>
import { onMounted, ref } from "vue";
export default {
    props: ["pontuacao"],
    setup(props) {
        const titulo = ref();

        onMounted(() => {
            console.log();
            if (props.pontuacao <= 300) {
                titulo.value = "flash";
            } else if ((props.pontuacao > 300) & (props.pontuacao <= 500)) {
                titulo.value = "Speed Gonzales";
            } else {
                titulo.value = "slowpoke";
            }
        });
        return { titulo };
    },
};
</script>

<style>
.rank {
    font-size: 2rem;
    color: black;
    font-weight: bold;
}
.titulo {
    font-size: 3em;
    color: red;
}
</style>
