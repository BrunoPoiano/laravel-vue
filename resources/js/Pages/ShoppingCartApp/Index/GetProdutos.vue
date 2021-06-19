<template>
    <div class="container">
        <div class="row">
            <div
                class="col-6 p-2"
                v-for="(prod, index) in produtos"
                :key="index"
            >
                <div class="card text-left">
                    <div class="card-body">
                        <h5 class="card-title text-capitalize">
                            {{ prod.nome }}
                        </h5>
                        <p class="card-text text-justify p-2">
                            {{ prod.descricao }}
                        </p>
                        <div class="row">
                            <div class="col">
                                <p class="card-text float-left col-6">
                                    Disponivel: {{ prod.quantidade }}
                                </p>
                                <p class="card-text float-left col-6">
                                    Preço: R${{ prod.preco }}
                                </p>
                            </div>
                        </div>
                        <div class="row p-3">
                            <label class="form-label">Quantidade</label>
                            <div class="col">
                                <form class="float-start col-6">
                                    <input
                                        type="number"
                                        min="0"
                                        :id="prod.id"
                                        :max="prod.quantidade"
                                        class="qtde form-control"
                                        v-on:change="qtde"
                                    />
                                </form>
                                <button
                                    :class="[
                                        prod.quantidade == 0
                                            ? 'btn-success disabled '
                                            : 'btn-success',
                                        'btn  float-left col-6',
                                    ]"
                                    @click="adicionarCarrinho(prod.id)"
                                >
                                    Add ao carrinho
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { onMounted, ref } from "vue";

export default {
    setup(props, context) {
        const produtos = ref([]);
        const fd = new FormData();
        const produto = ref();
        const quantidade = ref();

        const mensagem = ref(null);

        onMounted(() => {
            getProdutos();
        });

        const getProdutos = () => {
            axios.get(route("shoppingcart.layout.getprodutos")).then((resp) => {
                produtos.value = resp.data;
                console.log(resp.data);
            });
        };

        const qtde = (e) => {
            produto.value = e.target.id;
            quantidade.value = e.target.value;
        };

        const adicionarCarrinho = (id) => {
            if (produto.value == id) {
                fd.append("quantidade", quantidade.value);
                fd.append("produto", produto.value);
                axios
                    .post(route("shoppingcart.layout.carrinho"), fd)
                    .then((resp) => {
                        mensagem.value = resp.data;
                        context.emit("mensagem", mensagem.value);
                    });
            }
            context.emit(
                "mensagem",
                "Selecione Quantidade do produto desejado"
            );
        };

        return { produtos, quantidade, adicionarCarrinho, qtde };
    },
};
</script>

<style>
.card-title {
    font-size: 2.5rem;
    font: bolder;
    color: black;
}
.card-text {
    font-size: 1.1rem;
}
.qtde {
    max-width: 4rem;
}
</style>
