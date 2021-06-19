<template>
    <div class="container p-2">
        <div class="card card-body">
            <label class="form-label">Tamanho Desejado</label>
            <input
                class="form-control"
                min="5"
                max="15"
                type="range"
                v-model="tamanho"
                @change="gerador"
            />

            {{ tamanho }}

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="checkbox"
                    value="Maiusculas"
                    v-model="chars"
                    checked
                />
                <label
                    class="form-check-label float-left"
                    for="flexCheckDefault"
                >
                    Maiusculas
                </label>
            </div>
            <div class="form-check">
                <input
                    class="form-check-input"
                    type="checkbox"
                    value="Minusculas"
                    v-model="chars"
                />
                <label
                    class="form-check-label float-left"
                    for="flexCheckChecked"
                >
                    Minusculas
                </label>
            </div>
            <div class="form-check">
                <input
                    class="form-check-input"
                    type="checkbox"
                    v-model="chars"
                    value="Numeros"
                />
                <label
                    class="form-check-label float-left"
                    for="flexCheckChecked"
                >
                    Numeros
                </label>
            </div>
            <div class="form-check">
                <input
                    class="form-check-input"
                    type="checkbox"
                    v-model="chars"
                    value="Caracteres"
                />
                <label
                    class="form-check-label float-left"
                    for="flexCheckChecked"
                >
                    Caracteres
                </label>
            </div>

           
        </div>
    </div>
    <div class="palavra p-2">
        <p>Palavra: {{ palavra }}</p>
    </div>
</template>

<script>
import { ref } from "vue";

export default {
    setup() {
        const tamanho = ref(5);
        const palavra = ref("");
        const chars = ref(["Maiusculas"]);

        //Gerador de Palavras



        const gerador = (e) => {
            tamanho.value = e.target.value;

            console.log(tamanho.value)
            palavra.value = "";
            
            // Declara todos os caracteres
            const maiusculas = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            const minusculas = "abcdefghijklmnopqrstuvwxyz";
            const numeros = "0123456789";
            const caracteres = "!@#$%&*()+=-";

            for (let i = 0; i < tamanho.value; i++) {
                if (chars.value.includes("Maiusculas")) {
                    palavra.value += maiusculas.charAt(
                        Math.floor(Math.random() * maiusculas.length)
                    );
                }
                if (chars.value.includes("Minusculas")) {
                    palavra.value += minusculas.charAt(
                        Math.floor(Math.random() * minusculas.length)
                    );
                }
                if (chars.value.includes("Numeros")) {
                    palavra.value += numeros.charAt(
                        Math.floor(Math.random() * numeros.length)
                    );
                }
                if (chars.value.includes("Caracteres")) {
                    palavra.value += caracteres.charAt(
                        Math.floor(Math.random() * caracteres.length)
                    );
                }
                palavra.value = palavra.value.substring(0, tamanho.value)
            }
        };

        return { tamanho, palavra, chars, gerador };
    },
};
</script>

<style>
.container {
    max-width: 20rem;
}
.palavra {
    font-size: 2rem;
}
</style>
