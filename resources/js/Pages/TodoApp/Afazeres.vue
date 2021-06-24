<template>
    <li class="list-group-item p-0">
        <div class="container">
            <div class="float-left col-10 text-capitalize pt-3">
                <h3 :class="[afazer.finalizado ? 'finalizado' : '']">
                    {{ afazer.nome }} -
                    <span>{{ afazer.time }}</span>
                </h3>
            </div>
            <div class="float-right col-2">
                <button
                    :class="[
                        afazer.finalizado
                            ? 'btn btn-sm btn-secondary p-2 m-2'
                            : 'btn btn-sm btn-success p-2 m-2',
                    ]"
                    @click="feito(afazer)"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-check-lg"
                        viewBox="0 0 16 16"
                    >
                        <path
                            d="M13.485 1.431a1.473 1.473 0 0 1 2.104 2.062l-7.84 9.801a1.473 1.473 0 0 1-2.12.04L.431 8.138a1.473 1.473 0 0 1 2.084-2.083l4.111 4.112 6.82-8.69a.486.486 0 0 1 .04-.045z"
                        />
                    </svg>
                </button>

                <button
                    class="btn btn-sm btn-danger p-2 m-2"
                    @click="apagar(afazer)"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-trash"
                        viewBox="0 0 16 16"
                    >
                        <path
                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"
                        />
                        <path
                            fill-rule="evenodd"
                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </li>
</template>

<script>
import moment from "moment";
export default {
    props: ["afazer"],
    setup(props, context) {
        const feito = (afazer) => {
            axios
                .post(route("todo.layout.update"), { afazer: afazer.id })
                .then((resp) => {
                    if (resp.status == 200) {
                        context.emit("getAfazer");
                    }
                })
                .catch((erro) => {
                    console.log(erro);
                });
        };

        const apagar = (afazer) => {
            console.log(afazer);
            axios
                .post(route("todo.layout.delete"), { afazer: afazer.id })
                .then((resp) => {
                    console.log(resp);
                    context.emit("getAfazer");
                });
        };

        return {
            feito,
            apagar,
        };
    },
};
</script>

<style>
.finalizado {
    text-decoration: line-through;
    color: rgb(184, 184, 184);
}
</style>
