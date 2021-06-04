<template>
    <div class="container p-3">
        <div class="input-group-text mb-3">
            <input
                type="text"
                class="form-control"
                placeholder="Afazer"
                v-model="afazer"
                @keyup.enter="enviar"
            />
            <button type="button" class="btn btn-primary" @Click="enviar">
                Okay
            </button>
        </div>

        <div v-if="afazeres.length">
            <ul class="list-group">
                <afazeres
                    v-for="afazer in afazeres"
                    :key="afazer.id"
                    :afazer="afazer"
                    @getAfazer="getAfazeres"
                />
            </ul>
        </div>
        <div v-else>
            <h1>Sem conteudo</h1>
        </div>
    </div>
</template>

<script>
import { onMounted, ref } from "vue";
import afazeres from "./Afazeres.vue";

export default {
    components: { afazeres },
    setup() {
        const afazer = ref();
        const enviar = () => {
            axios
                .post(route("todo.layout.store"), { afazer: afazer.value })
                .then((resp) => {
                    if (resp.data == true) {
                        afazer.value = "";
                        getAfazeres();
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        };

        const afazeres = ref([]);

        const getAfazeres = () => {
            axios
                .get(route("todo.layout.getAfazeres"))
                .then((resp) => {
                    afazeres.value = resp.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        };

        onMounted(() => {
            getAfazeres();
        });
        return { enviar, afazer, afazeres, getAfazeres };
    },
};
</script>

<style></style>
