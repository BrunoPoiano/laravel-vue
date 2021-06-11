<template>

    <div class="p-4" v-if="conteudoTitulo">
        <h1 class="fs-2 text-left fw-bold text-capitalize">
            {{ conteudoTitulo }}
        </h1>
    </div>

    <div class="col float-center p-3">
        <div class="row" v-if="posts.length">
            <div class="" v-for="(post, index) in posts" :key="index">
                <h1 class="card-title text-capitalize">
                    {{ post.titulo }}
                </h1>
                <div class="row">
                    <h5 class="card-secao text-left fw-bold">
                        {{ post.nome }}
                    </h5>
                    <div :class="post.path ? 'col-4' : ''">
                        <div v-if="post.path">
                            <img
                                :src="'/storage/' + post.url[1]"
                                class="card-img-top img-responsive"
                            />
                        </div>
                    </div>
                    <div
                        :class="
                            post.path
                                ? 'col-8 card-text text-justify '
                                : 'card-text text-justify'
                        "
                    >
                        <p>
                            {{ post.conteudo }}
                        </p>
                    </div>
                </div>

                <div class="col">
                    <div class="card-body">
                        <div class="p-2 fs-5 text-capitalize">
                            <h1
                                v-for="tag in post.tags"
                                :key="tag"
                                class="card-text card-tags"
                                @click="getTag(tag)"
                            >
                                {{ tag }}
                            </h1>
                        </div>
                    </div>
                    <div class="dropdown pb-2 pr-2">
                        <a
                            class="
                                btn btn-secondary
                                dropdown-toggle
                                float-right
                            "
                            href="#"
                            role="button"
                            id="dropdownMenuLink"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                        </a>

                        <ul
                            class="dropdown-menu"
                            aria-labelledby="dropdownMenuLink"
                        >
                            <div v-if="post.deletar">
                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="#"
                                        @click="deletarPublicacao(post.id)"
                                        >Deletar</a
                                    >
                                </li>
                            </div>
                        </ul>
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
export default {
    props: ["id"],
    setup(props) {
        const posts = ref([]);
        const conteudoTitulo = ref(null);
        onMounted(() => {
            axios
                .post(route("blog.layout.getContentbyId"), props)
                .then((resp) => {
                    conteudoTitulo.value = null;
                    montarConteudo(resp);
                });
        });

        const getTag = (tag) => {
            console.log(tag);
            axios
                .post(route("blog.layout.getTagsConteudo"), { tag })
                .then((resp) => {
                    conteudoTitulo.value = tag;
                    montarConteudo(resp);
                });
        };

        const montarConteudo = (resp) => {
            posts.value = resp.data;

            posts.value.forEach((post) => {
                if (post.path) {
                    post.url = post.path.split("public/");
                }
            });

            posts.value.forEach((pv) => {
                if (pv.tags) {
                    pv.tags = pv.tags.split(" ");
                }
            });
        };

        return {
            posts,
            getTag,
            conteudoTitulo,
        };
    },
};
</script>

<style>
.card-title {
    font-size: 2.5rem;
    font: bolder;
    color: black;
}
.card-tags {
    display: inline-block;
    padding: 6px 12px;
    background: #eee;
    border-radius: 20px;
    font-size: 14px;
    letter-spacing: 1px;
    font-weight: bold;
    color: #777;
    cursor: pointer;
}
</style>
