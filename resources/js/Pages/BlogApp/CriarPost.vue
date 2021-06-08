<template>
    <button
        type="button"
        class="btn btn-success float-center"
        data-bs-toggle="modal"
        data-bs-target="#criarPostModal"
    >
        Criar Post
    </button>

    <!-- Modal -->
    <div
        class="modal fade"
        id="criarPostModal"
        tabindex="-1"
        aria-labelledby="criarPostModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Criar Blog Post
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label float-left">Imagem</label>
                        <input
                            type="file"
                            class="form-control"
                            v-on:change="enviarImg"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label float-left">Titulo</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="post.titulo"
                        />
                    </div>
                    <div class="mb-3" v-if="secao.length">
                        <label class="form-label float-left">Secao</label>
                        <select
                            id="secao"
                            name="secao"
                            class="form-control"
                            aria-label="Default select example"
                            required
                            v-model="post.sec"
                        >
                            <option
                                v-for="s in secao"
                                :key="s.id"
                                :value="s.id"
                            >
                                {{ s.nome }}
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label float-left">Tags</label>

                        <input
                            type="text"
                            class="form-control"
                            @keyup="addTags"
                            v-model="temptags"
                        />

                        <div
                            v-for="tag in tags"
                            :key="tag"
                            class="pill"
                            @click="deletetag(tag)"
                        >
                            {{ tag }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <textarea
                            v-model="post.conteudo"
                            type="text"
                            class="form-control"
                            id="conteudo"
                            cols="30"
                            rows="10"
                            placeholder="Conteudo"
                            aria-describedby="conteudoHelp"
                            required
                        ></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="criarPost"
                    >
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import { ref } from "vue";
import GetSecoes from "./Composables/GetSecoes";
export default {
    emits: ["cont"],
    components: ["PictureInput"],
    setup(props, context) {
        const { getsecoes, secao, errorSecao } = GetSecoes();
        getsecoes();

        const post = ref({ titulo: "", sec: "", conteudo: "" });
        const tags = ref([]);
        const temptags = ref();
        const tag = ref("");

        const imag = ref();
        let fdata = new FormData();

        const enviarImg = (e) => {
            imag.value = e.target.files[0];
            fdata.append("file", imag.value);
        };
 

        const addTags = (e) => {
            if (e.key === " " && temptags.value) {
                if (!tags.value.includes(temptags.value)) {
                    tags.value.push(temptags.value);
                }
                temptags.value = "";
            }
        };

        const deletetag = (tag) => {
            tags.value = tags.value.filter((item) => {
                return tag !== item;
            });
        };

        const criarPost = () => {
            tags.value.forEach((tg) => {
                tag.value += tg + " ";
            });

            fdata.append("titulo", post.value.titulo);
            fdata.append("sec", post.value.sec);
            fdata.append("conteudo", post.value.conteudo);
            fdata.append("tags", tag.value);

            axios
                .post(route("blog.layout.store"), 
     
                    fdata,
                )
                .then((resp) => {
                    console.log(resp);
                    context.emit("cont");
                    tag.value = "";

                    //modal("#criarPostModal").modal("hide");
                });
        };

        return {
            post,
            criarPost,
            secao,
            addTags,
            temptags,
            deletetag,
            tags,
            ////////////////
            enviarImg,
        };
    },
};
</script>

<style>
.pill {
    display: inline-block;
    margin: 20px 10px 0 0;
    padding: 6px 12px;
    background: #eee;
    border-radius: 20px;
    font-size: 12px;
    letter-spacing: 1px;
    font-weight: bold;
    color: #777;
    cursor: pointer;
}
</style>
