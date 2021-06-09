<template>
  <div class="row pb-4 g-0">
    <div class="p-2">
      <criar-post @cont="getConteudo" />
    </div>
    <div class="col">
      <aside class="col-3 float-start m-0">
        <get-secao @idsc="getConteudo" />
      </aside>

      <div class="col float-center">
        <div v-if="conteudoTitulo">
          <h1 class="fs-2 text-left fw-bold pt-3">
            {{ conteudoTitulo }}
          </h1>
        </div>

        <div class="row" v-if="posts.length">
          <div class="" v-for="post in posts" :key="post.id">
            <h5 class="card-secao text-left fw-bold pt-3">
              {{ post.nome }}
            </h5>
              <div class="card">
                <div v-if="post.path">
                  <img :src="'/storage/' + post.url[1]" class="card-img-top img-responsive" />
                </div>

                <div class="card-body">
                  <h5 class="card-title text-capitalize">
                    {{ post.titulo }}
                  </h5>
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
                  <p class="card-text">
                    {{ post.conteudo }}
                  </p>
                </div>
                <div class="dropdown pb-2 pr-2">
                  <a
                    class="btn btn-secondary dropdown-toggle float-right"
                    href="#"
                    role="button"
                    id="dropdownMenuLink"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                  </a>

                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
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
    </div>
  </div>
</template>

<script>
import { onMounted, ref } from "vue";
import CriarPost from "./CriarPost.vue";
import GetSecao from "./GetSecao.vue";
export default {
  components: { CriarPost, GetSecao },
  setup() {
    const posts = ref([]);
    const posttags = ref();
    const conteudoTitulo = ref();

    const getConteudo = async (id) => {
      if (!id) {
        id = null;
      }
      console.log("id", id);
      axios.post(route("blog.layout.getConteudo"), { id }).then((resp) => {
        conteudoTitulo.value = null;
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

    const deletarPublicacao = (id) => {
      axios
        .post(route("blog.layout.delete"), { id })
        .then((resp) => {
          getConteudo();
        })
        .catch((err) => {
          console.log(err);
        });
    };

    const getTag = (tag) => {
      console.log(tag);
      axios.post(route("blog.layout.getTagsConteudo"), { tag }).then((resp) => {
        conteudoTitulo.value = tag;
        montarConteudo(resp);
      });
    };

    onMounted(() => {
      getConteudo();
    });

    return {
      posts,
      getConteudo,
      deletarPublicacao,
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
.card-secao {
  padding: 2px;
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
