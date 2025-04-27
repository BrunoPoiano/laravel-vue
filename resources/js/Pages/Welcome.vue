<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div class="relative flex min-h-screen flex-col selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="flex items-end gap-5 py-10">
                    <nav v-if="canLogin" class="-mx-3 flex w-full flex-1 justify-end">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('products.index')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Products
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Log in
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
                </header>
                <h2>Laravel 10 and Vue 3 Full-Stack Implementation Challenge</h2>
                <p>
                    This challenge evaluates your ability to implement core Laravel and Vue patterns in a full-stack environment. You'll be building
                    features that demonstrate your understanding of both backend and frontend technologies, focusing on clean architecture, efficient
                    data handling, and modern UI implementations. The tasks are designed to showcase your ability to write maintainable, performant
                    code while following best practices for both Laravel and Vue development.
                </p>

                <ul>
                    <li>
                        <h3>STORY-001</h3>
                        <h4>Implement Data Grid with Filtering and Pagination</h4>
                        <p>
                            User Story: Implement a filterable, paginated data grid using Laravel's backend pagination with Inertia.js and Vue 3 to
                            demonstrate efficient data handling and responsive UI patterns.
                        </p>
                    </li>

                    <li>
                        <h3>STORY-002</h3>
                        <h4>Multi-step Form with Validation and State Persistence</h4>
                        <p>
                            User Story: Implement a multi-step form with backend validation, temporary state persistence, and optimistic UI updates to
                            demonstrate advanced form handling techniques.
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
