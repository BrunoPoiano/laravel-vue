<template>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <transition name="fade" >
                        <p v-if="show">{{ quiz[index].perguntas }}</p>
                    </transition>
                </div>
            </div>

            <div class="card-footer">
                <button class="btn btn-success" @click="anterior">
                    Anterior
                </button>

                <button
                    :class="[
                        index.value < quiz.length - 1
                            ? 'btn-success'
                            : 'btn-primary',
                        'btn ',
                    ]"
                    @click="proxima"
                >
                    Proxima
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, shallowRef } from "@vue/reactivity";
export default {
    setup() {
        const quiz = ref([
            { id: 0, titulo: "titulo", perguntas: "pergunta1" },
            { id: 1, titulo: "titulo", perguntas: "pergunta2" },
        ]);
        const index = ref(0);

        console.log("tamnh: ", quiz.value.length);
        console.log("index: ", index.value);

        const show = ref(true);

        const proxima = () => {
            show.value = !show.value;
            if (index.value < quiz.value.length - 1) {
                index.value++;
                console.log("index: ", index.value);
                console.log("tamnh: ", quiz.value.length);
            } else {
                console.log("finalizado");
            }
        };

        function wait(milliseconds) {
            const date = Date.now();
            let currentDate = null;
            do {
                currentDate = Date.now();
            } while (currentDate - date < milliseconds);
        }

        const anterior = () => {
            index.value--;
        };

        /////////////////////

        const quizteste = shallowRef([
            { template: "pergunta1" },
            { template: "pergunta2" },
        ]);

        return {
            quiz,
            index,
            proxima,
            anterior,

            ////////
            show,
            quizteste,
        };
    },
};
</script>

<style>
.component-fade-enter-active,
.component-fade-leave-active {
    transition: opacity 0.3s ease;
}

.component-fade-enter-from,
.component-fade-leave-to {
    opacity: 0;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 1s ease;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
</style>
