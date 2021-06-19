<template>
    <div class="card">
        <div class="card-header" v-if="edit">Editar Produto</div>
        <div class="card-header" v-else>Criar Inventario</div>
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
        <div class="card-footer" v-if="edit">
            <button class="btn btn-warning" @click="editarConteudo">
                editar
            </button>
        </div>
        <div class="card-footer" v-else>
            <button class="btn btn-success" @click="criarproduto">OK</button>
        </div>
    </div>

    <div class="container">
        <div class="card" v-for="(prod, index) in produtos" :key="index">
            <p>
                <button
                    class="btn btn-primary"
                    type="button"
                    data-bs-toggle="collapse"
                    :data-bs-target="'#collapse' + prod.id"
                    aria-expanded="false"
                    :aria-controls="prod.id"
                >
                    {{ prod.nome }}
                </button>
            </p>
            <div class="collapse" :id="'collapse' + prod.id">
                <div class="card card-body">
                    <div class="d-flex w-100 justify-content-between p-1">
                        <h5 class="mb-1">{{ prod.nome }}</h5>
                        <small>{{ prod.time }}</small>
                    </div>
                    <div class="row">
                        <div class="text-left col-6 pt-2">
                            <p class="mb-1">Preço: {{ prod.preco }}.</p>
                            <p class="mb-1">
                                quantidade: {{ prod.quantidade }}.
                            </p>
                        </div>

                        <div class="col-6">
                            <div class="row-6">
                                <button
                                    class="btn btn-danger"
                                    @click="apagar(prod.id)"
                                >
                                    apagar
                                </button>
                            </div>
                            <div class="row-6">
                                <button
                                    class="btn btn-warning"
                                    @click="editar(prod)"
                                >
                                    editar
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
import moment from "moment";
export default {
    emits: ["mensagem"],
    setup(props, context) {
        const inventario = ref({
            nome: "",
            descricao: "",
            quantidade: "",
            preco: "",
        });
        const produtos = ref([]);
        const edit = ref(false);

        const produto = new FormData();

        const criarproduto = () => {
            produto.append("nome", inventario.value.nome);
            produto.append("descricao", inventario.value.descricao);
            produto.append("quantidade", inventario.value.quantidade);
            produto.append("preco", inventario.value.preco);

            axios
                .post(route("shoppingcart.layout.store"), produto)
                .then((resp) => {
                    console.log(resp);
                    if (resp.data == true) {
                        inventario.value.nome = "";
                        inventario.value.descricao = "";
                        inventario.value.quantidade = "";
                        inventario.value.preco = "";
                        getProdutos();
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
        };

        onMounted(() => {
            getProdutos();
        });

        const getProdutos = () => {
            axios.get(route("shoppingcart.layout.getprodutos")).then((resp) => {
                produtos.value = resp.data;

                produtos.value.forEach((el) => {
                    moment.locale("pt-br");
                    el.time = moment(el.created_at).format(
                        "Do MMMM YYYY, h:mm"
                    );
                });
                console.log(produtos.value);
            });
        };

        const editar = (ind) => {
            edit.value = true;
            console.log(ind);
            inventario.value.nome = ind.nome;
            inventario.value.descricao = ind.descricao;
            inventario.value.quantidade = ind.quantidade;
            inventario.value.preco = ind.preco;
            produto.append("id", ind.id);
        };

        const editarConteudo = () => {
            produto.append("nome", inventario.value.nome);
            produto.append("descricao", inventario.value.descricao);
            produto.append("quantidade", inventario.value.quantidade);
            produto.append("preco", inventario.value.preco);

            axios
                .post(route("shoppingcart.layout.update"), produto)
                .then((resp) => {
                    context.emit("mensagem", resp.data);
                    inventario.value.nome = "";
                    inventario.value.descricao = "";
                    inventario.value.quantidade = "";
                    inventario.value.preco = "";
                    getProdutos();
                    edit.value = false;
                });
        };

        const apagar = (id) => {
            axios
                .post(route("shoppingcart.layout.apagar"), { id })
                .then((resp) => {
                    console.log(resp);
                    getProdutos();
                });
        };

        return {
            inventario,
            criarproduto,
            produtos,
            editar,
            edit,
            editarConteudo,
            apagar,
        };
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
