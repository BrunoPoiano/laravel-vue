
import { onMounted, ref } from "vue";

const GetSecao = () => {

    const secao = ref([]);
    const errorSecao = ref(null);

    const getsecoes = async () => {
        axios
            .get(route("blog.layout.getSecao"), )
            .then((resp) => {
                secao.value = resp.data;
            })
            .catch((err) => {
                errorSecao.value = err.value
            });
    };

    return {getsecoes, secao, errorSecao}
};

export default GetSecao;