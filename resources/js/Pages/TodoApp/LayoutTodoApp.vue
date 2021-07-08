<template>
    <app-layout class="teste">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Todo App
            </h2>
        </template>

        <div class="container todo ">
            <input-todo />
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import InputTodo from "./InputTodo.vue";

export default {
    components: {
        AppLayout,
        InputTodo,
    },
};
</script>

<style scoped>
.todo {
    margin-top: 2rem;
    max-width: 50rem;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgb(0, 0, 0)

}
.teste {
    background: rgb(22, 22, 22);
}
</style>
