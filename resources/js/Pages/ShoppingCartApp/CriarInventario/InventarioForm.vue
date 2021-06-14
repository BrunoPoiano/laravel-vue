<template>
    <div class="card">
        <div class="card-header">Criar Inventario</div>
        <div class="card-body text-left">
            <div class="mb-3">
                <label class="form-label">Nome do Produto</label>
                <input
                    type="text"
                    class="form-control"
                    v-model="inventario.nome"
                    required
                />
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Descricao</label>
                <textarea
                    type="text"
                    class="form-control"
                    v-model="inventario.descricao"
                >
                </textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Quantidade</label>
                <input
                    type="number"
                    min="0"
                    class="form-control"
                    v-model="inventario.quantidade"
                    required
                />
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Preço</label>
                <input
                    type="number"
                    min="0"
                    class="form-control"
                    v-model="inventario.preco"
                    required
                />
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-success" @click="criarproduto">OK</button>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";

export default {
    setup() {
        const inventario = ref({
            nome: "",
            descricao: "",
            quantidade: "",
            preco: "",
        });
        const produto = new FormData();

        const criarproduto = () => {
            produto.append("nome", inventario.value.nome);
            produto.append("descricao", inventario.value.descricao);
            produto.append("quantidade", inventario.value.quantidade);
            produto.append("preco", inventario.value.preco);

            axios
                .post(route("shoppingcart.layout.store"), produto)
                .then((resp) => {
                      console.log(resp)
                    if (resp.data == true) {
                        inventario.value = '';
                    }
                }).catch(err=>{
                  console.log(err)
                });
        };

        return { inventario, criarproduto };
    },
};
</script>

<style>
.card {
    max-width: 420px;
    margin: 30px auto;
    background: white;
    border-radius: 10px;
}
</style>
