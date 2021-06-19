<template>
    <div class="container">
        <div class="p-3">
            <h1 class="total fw-bold text-capitalize">Total: R${{ total }}</h1>
        </div>

        <div v-if="carrinho.length" class="row p-2">
            <div v-for="(car, index) in carrinho" :key="index" class="p-2">
                <p class="float-left fw-bold text-capitalize">{{ car.time }}</p>
                <br />
                <div class="card card-body">
                    <div class="row">
                        <div class="col-6" v-if="car.pago">
                            <h1 class="fw-bold">{{ car.nome }}</h1>
                            <h1 class="fw-bold">Comprado</h1>
                        </div>
                        <div class="col-6" v-else>
                            <h1 class="fw-bold">{{ car.nome }}</h1>
                            <h1>Quantidade: {{ car.quantidade }}</h1>
                            <h1>Preco: R${{ car.preco }}</h1>
                            <h1>Valor: R${{ car.valor }}</h1>
                        </div>
                        <div class="col-6 d-grid gap-2">
                            <button
                                :class="[
                                    car.pago || car.quantidade == 0
                                        ? 'disabled'
                                        : '',
                                    'btn btn-success',
                                ]"
                                @click="pagar(car.id)"
                            >
                                Pagar
                            </button>
                            <button
                                class="btn btn-warning"
                                @click="removercarrinho(car.id)"
                            >
                                Remover do carrinho
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-else>
            <h1>Carregando...</h1>
        </div>
    </div>
</template>

<script>
import { onMounted, ref } from "@vue/runtime-core";
import moment from "moment";

export default {
    setup(props, context) {
        const carrinho = ref([]);
        const total = ref(0);

        const getprodutoscarrinho = () => {
            
            axios
                .get(route("shoppingcart.layout.getprodutoscarrinho"))
                .then((resp) => {
                    console.log(resp.data);
                    carrinho.value = resp.data;
                    total.value = 0;

                    carrinho.value.forEach((el) => {
                        moment.locale("pt-br");
                        el.time = moment(el.created_at).format(
                            "Do MMMM YYYY - h:mm"
                        );
                        total.value += el.valor;
                    });
                });
        };

        const pagar = (id) => {
            console.log(id);
            axios
                .post(route("shoppingcart.layout.pagamento"), { id })
                .then((resp) => {
                    console.log(resp);
                    context.emit("mensagem", resp.data);
                    getprodutoscarrinho();
                });
        };

        const removercarrinho = (id) => {
            axios
                .post(route("shoppingcart.layout.removercarrinho"), { id })
                .then((resp) => {
                    console.log(resp);
                    getprodutoscarrinho();
                });
        };

        onMounted(() => {
            getprodutoscarrinho();
        });

        return { carrinho, pagar, removercarrinho, total };
    },
};
</script>

<style>
.total{
    font-size: 3rem;
}
</style>
