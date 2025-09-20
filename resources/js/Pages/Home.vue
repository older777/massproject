<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useStore } from 'vuex';
import Menu from '@/Layouts/MenuLayout.vue';
import Filters from '@/Layouts/FiltersLayout.vue';
import Search from '@/Layouts/SearchLayout.vue';
import Products from '@/Layouts/ProductsLayout.vue';
import Product from '@/Layouts/ProductLayout.vue';

defineProps({
    catalog: {
        type: String,
        default: ''
    },
    search: {
        type: String,
    },
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
    catalogStats: {
        type: Object,
    },
    paging: {
        type: Object,
    },
    products: {
        type: Object,
    },
    product: {
        type: Object,
    },
});
const messageSuccess = ref(''), messageError = ref('');
const store = useStore();

const showSuccess = (message) => {
    messageSuccess.value = message;
    if (message) {
        orderForm.reset();
    }
};
const showError = (message) => {
    if (typeof message.messageError !== 'undefined') {
        messageError.value = message.messageError;
    } else {
        messageError.value = message.message;
        if (message.errors.name) {
            orderForm.setError('name', message.errors.name[0]);
        };
        if (message.errors.email) {
            orderForm.setError('email', message.errors.email[0]);
        };
        if (message.errors.message) {
            orderForm.setError('message', message.errors.message[0]);
        };
    }
};
</script>

<template>
    <Head title="Магазин" />
    <div class="relative min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <Menu :canLogin="canLogin" :canRegister="canRegister" />
        <Search :search="search" />
        <div class="max-w-7xl mx-auto lg:p-2">
            <div class="flex">
                <div class="mt-2 lg:w-1/4 sm:w-full">
                    <Filters :catalog-stats="catalogStats" :catalog="catalog" />
                </div>
                <div class="mt-2 lg:w-3/4 sm:w-full">
                    <Products v-if="products" :products="products.data" :paging="paging" />
                    <Product v-if="product" :product="product.data" />
                </div>
            </div>
            <div class="mt-16 px-6 sm:items-center sm:justify-left">
                <div class="ms-4 text-sm text-gray-500 dark:text-gray-400 sm:text-start sm:ms-0 mx-2">
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
.message-enter-active,
.message-leave-active {
    transition: all .3s ease-out;
    transform: translateX(0);
}

.message-enter-from,
.message-leave-to {
    transform: translateX(30vw);
    opacity: 0;
}
</style>
