<template>
    <div class="container">
        <p>Gerador De Senha</p>
        <div class="p-2">
            <div class="boxs card card-body">
                <div class="col">
                    <p>{{ palavra }}</p>
                </div>
            </div>
        </div>
        <p class="p-2">Personalize sua Senha</p>
        <div class="boxs card card-body">
            <div class="row">
                <div class="col-2 pt-2">
                    <div class="card">
                        <h1 class="tmh">{{ tamanho }}</h1>
                    </div>
                </div>
                <div class="col">
                    <input
                        class="form-control teste"
                        min="0"
                        max="30"
                        type="range"
                        v-model="tamanho"
                        @change="gerador"
                        @click="gerador"
                    />
                </div>
            </div>

            <div class="opcoes p-3">
                <div class="row">
                    <div class="col-6">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                :value="valores.maiusculas"
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
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                :value="valores.minusculas"
                                v-model="chars"
                            />
                            <label
                                class="form-check-label float-left"
                                for="flexCheckChecked"
                            >
                                Minusculas
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                v-model="chars"
                                :value="valores.numeros"
                            />
                            <label
                                class="form-check-label float-left"
                                for="flexCheckChecked"
                            >
                                Numeros
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                v-model="chars"
                                :value="valores.caracteres"
                            />
                            <label
                                class="form-check-label float-left"
                                for="flexCheckChecked"
                            >
                                Simbolos
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card boxs">
            <p>Palindromo?</p>

            <div class="card-body">
                <input type="text" class="form-control" v-model="palavra" />
                <p class="text-capitalize">{{ palindromo }}</p>
            </div>
            <div class="col pb-1">
                <button class="btn btn-success" @click="encontrarpalindromo">
                    Verificar
                </button>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card boxs">
            <div class="p-2">
                <button class="btn btn-success" @click="gerarteste">
                    Gerar Palavras
                </button>
            </div>
            <div class="p-2 tmh text-capitalize">
                <h1>palindromo - {{ palindro }}</h1>
                <h1>não palindromo - {{ naopalindro }}</h1>
            </div>
            <div class="pb-2">
                <div v-for="(fim, index) in final" :key="index">
                    <p>{{ fim }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";

export default {
    setup() {
        const tamanho = ref(5);
        const palavra = ref("");
        const valores = ref({
            caracteres: "!@#$%&*()+=-/\|[]{}<>",
            numeros: "0123456789",
            minusculas: "abcdefghijklmnopqrstuvwxyz",
            maiusculas: "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
        });
        const chars = ref(["ABCDEFGHIJKLMNOPQRSTUVWXYZ"]);
        const palindromo = ref();

        //Gerador de Palavras
        const gerador = (e) => {
            tamanho.value = e.target.value;
            palavra.value = "";
            palindromo.value = "";

            for (let i = 0; i < tamanho.value; i++) {
                var thing =
                    chars.value[Math.floor(Math.random() * chars.value.length)];
                palavra.value += thing.charAt(
                    Math.floor(Math.random() * thing.length)
                );
            }
            // palavra.value = palavra.value.substring(0, tamanho.value);
        };

        const encontrarpalindromo = () => {
            let palin = palavra.value;
            palin = palin.replaceAll(" ", "");
            palin = palin.toUpperCase();
            let y = palin.length - 1;

            if (
                palin.length == 1 ||
                palin.length == null ||
                palin.length == 0
            ) {
                palindromo.value =
                    "Palavra precisa ter no minimo dois caracteres ";
            } else {
                for (let i = 0; i < palin.length; i++) {
                    let teste = text(palin[i], palin[y]);
                    if (teste == false) {
                        palindromo.value = "não é um palindromo";
                        i = palin.length;
                    } else {
                        palindromo.value = "palindromo";
                    }
                    y--;
                }
            }
        };

        const text = (l1, l2) => {
            if (l1 === l2) {
                return true;
            } else {
                return false;
            }
        };

        ////////////////////////////////////////////

        const teste = ref([]);
        const temp = ref("");
        const valor = ref("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
        const resul = ref("");
        const final = ref([]);
        const palindro = ref();
        const naopalindro = ref();

        const gerarteste = () => {
            teste.value.length = 0;
            final.value.length = 0;
            naopalindro.value = 0;
            palindro.value = 0;
            for (let i = 0; i < 10; i++) {
                temp.value = "";
                for (let i = 0; i < 5; i++) {
                    var thing =
                        valor.value[
                            Math.floor(Math.random() * valor.value.length)
                        ];
                    temp.value += thing.charAt(
                        Math.floor(Math.random() * thing.length)
                    );
                }
                teste.value.push(temp.value);
            }

            teste.value.forEach((el) => {
                let y = el.length - 1;
                let tes = 0;
                for (let i = 0; i < el.length; i++) {
                    let teste = text(el[i], el[y]);
                    if (teste == false) {
                        resul.value = "não é um palindromo - " + el;
                        naopalindro.value++;
                        i = el.length;
                    } else {
                        resul.value = "palindromo - " + el;
                        tes++;
                        console.log(resul.value);
                    }
                    if (tes == 5) {
                        palindro.value++;
                    }
                    y--;
                }
                final.value.push(resul.value);
            });
        };

        return {
            tamanho,
            palavra,
            chars,
            gerador,
            valores,
            palindromo,
            encontrarpalindromo,

            /////////////
            gerarteste,
            final,
            palindro,
            naopalindro,
        };
    },
};
</script>

<style scoped>
.container {
    max-width: 50rem;
    padding-top: 1rem;
    padding-bottom: 2rem;
}
p {
    font-size: 2rem;
    color: black;
    text-align: center;
}
.tmh {
    font-size: 1.5rem;
}
.opcoes {
    font-size: 2rem;
}
.boxs {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}

input[type="range"] {
    height: 30px;
    -webkit-appearance: none;
    margin: 10px 0;
    width: 100%;
}
input[type="range"]:focus {
    outline: none;
}
input[type="range"]::-webkit-slider-runnable-track {
    width: 100%;
    height: 2px;
    cursor: pointer;

    box-shadow: 1px 1px 1px #000000;
    background: #010305;
    border-radius: 14px;
    border: 1px solid #000000;
}
input[type="range"]::-webkit-slider-thumb {
    box-shadow: 1px 1px 1px #000000;
    border: 1px solid #000000;
    height: 22px;
    width: 21px;
    border-radius: 43px;
    background: #fcfcfc;
    cursor: pointer;
    -webkit-appearance: none;
    margin-top: -11px;
}
input[type="range"]:focus::-webkit-slider-runnable-track {
    background: #010305;
}
input[type="range"]::-moz-range-track {
    width: 100%;
    height: 2px;
    cursor: pointer;

    box-shadow: 1px 1px 1px #000000;
    background: #010305;
    border-radius: 14px;
    border: 1px solid #000000;
}
input[type="range"]::-moz-range-thumb {
    box-shadow: 1px 1px 1px #000000;
    border: 1px solid #000000;
    height: 22px;
    width: 21px;
    border-radius: 43px;
    background: #fcfcfc;
    cursor: pointer;
}
input[type="range"]::-ms-track {
    width: 100%;
    height: 2px;
    cursor: pointer;

    background: transparent;
    border-color: transparent;
    color: transparent;
}
input[type="range"]::-ms-fill-lower {
    background: #010305;
    border: 1px solid #000000;
    border-radius: 28px;
    box-shadow: 1px 1px 1px #000000;
}
input[type="range"]::-ms-fill-upper {
    background: #010305;
    border: 1px solid #000000;
    border-radius: 28px;
    box-shadow: 1px 1px 1px #000000;
}
input[type="range"]::-ms-thumb {
    margin-top: 1px;
    box-shadow: 1px 1px 1px #000000;
    border: 1px solid #000000;
    height: 22px;
    width: 21px;
    border-radius: 43px;
    background: #fcfcfc;
    cursor: pointer;
}
input[type="range"]:focus::-ms-fill-lower {
    background: #010305;
}
input[type="range"]:focus::-ms-fill-upper {
    background: #010305;
}
</style>
