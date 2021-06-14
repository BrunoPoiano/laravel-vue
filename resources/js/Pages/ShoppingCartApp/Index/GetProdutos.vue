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
                            <div class="col ">
                                <p class="card-text float-left col-6 ">
                                    Quantidade: {{ prod.quantidade }}
                                </p>
                                <p class="card-text float-left col-6">
                                    Preço: R${{ prod.preco }}
                                </p>
                            </div>
                        </div>
                        <div class="p-3">
                        <button class="btn btn-success">Add ao carrinho</button>

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
    setup() {
        const produtos = ref([]);

        onMounted(() => {
            getProdutos();
        });

        const getProdutos = () => {
            axios.get(route("shoppingcart.layout.getprodutos")).then((resp) => {
                produtos.value = resp.data;
                console.log(resp.data);
            });
        };

        return { produtos };
    },
};
</script>

<style>
.card-title {
    font-size: 2.5rem;
    font: bolder;
    color: black;
}
.card-text{
    font-size: 1.1rem;
    }
</style>
