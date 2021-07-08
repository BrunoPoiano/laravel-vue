<template>
    <div class="container p-3">
        <div class="input-group-text mb-3 divinput">
            <input
                type="text"
                class="form-control input"
                placeholder="Afazer"
                v-model="afazer"
                @keyup.enter="enviar"
            />
            <button type="button" class="btn btn-success" @Click="enviar">
                Okay
            </button>
        </div>

        <div v-if="afazeres.length">
            <ul class="list-group">
                <div class="div">
                    <transition-group name="list" tag="p">
                        <afazeres
                            v-for="afazer in afazeres"
                            :key="afazer.id"
                            :afazer="afazer"
                            @getAfazer="getAfazeres"
                        />
                    </transition-group>
                </div>
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
import moment from "moment";

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
                    afazeres.value.forEach((el) => {
                        moment.locale("pt-br");
                        el.time = moment(el.created_at).format(
                            "Do MMMM YYYY, h:mm"
                        );
                    });
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

<style scoped>
.divinput {
    background: rgba(44, 44, 44, 0.884);
    border: 0;
}
.input {
    color: white;
    background: rgb(41, 41, 41);
    border: 0;
    font-size: 1.5rem;
}

/* Transição */
.list-item {
    display: inline-block;
    margin-right: 10px;
}
.list-enter-active,
.list-leave-active {
    transition: all 1s ease;
}
.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateY(30px);
}
</style>
