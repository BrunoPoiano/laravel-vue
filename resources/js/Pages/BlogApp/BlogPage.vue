<template>
  <div class="row pb-4 g-0 ">
    <div class="p-2 ">
      <criar-post @cont="getConteudo" />
    </div>
    <div class="col">
      <div class="col-3 float-start m-0">
        <get-secao @idsc="getConteudo" />
      </div>
      <div class="col float-center ">
        
          <div class="row " v-if="posts.length">
            <div class="col" v-for="post in posts" :key="post.id">
              <h5 class="card-secao text-left fw-bold pt-3">
                {{ post.nome }}
              </h5>
              <div class="card">
                  <div v-if="post.path">
                <img src="" class="card-img-top" alt="..." />

                  </div>
                <div class="card-body">
                  <h5 class="card-title">{{ post.titulo }}</h5>
                  <div v-for="tag in post.tags" :key="tag">
                    <h1 class="card-text card-tags">
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

    const getConteudo = async (id) => {
      if (!id) {
        id = 1;
      }
      console.log("id", id);
      axios.post(route("blog.layout.getConteudo"), { id }).then((resp) => {
        console.log(resp.data);
        posts.value = resp.data;

        posts.value.forEach((pv) => {
          pv.tags = pv.tags.split(" ");
          console.log(pv.tags);
        });
      });
    };

    const deletarPublicacao = (id) => {
      axios
        .post(route("blog.layout.delete"), { id })
        .then((resp) => {
          console.log(resp);
          getConteudo();
        })
        .catch((err) => {
          console.log(err);
        });
    };

    onMounted(() => {
      getConteudo();
    });

    return { posts, getConteudo, deletarPublicacao };
  },
};
</script>

<style>
.card-title {
  font-size: 1.5rem;
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
  font-size: 12px;
  letter-spacing: 1px;
  font-weight: bold;
  color: #777;
  cursor: pointer;
}
</style>
