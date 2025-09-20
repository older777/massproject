<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    products: {
        type: Object,
    },
    paging: {
        type: Object,
    }
});
</script>

<template>
    <div v-if="products.length" class="w-full mx-auto px-4 flex flex-wrap flex-shrink">
        <Link :href="route('product', product.id)" v-for="product in products" class="group px-4 mb-6 hover:bg-gray-300 py-2">
            <div>
                <img :src="product.preview" class="lg:w-[250px]">
            </div>
            <div class="flex justify-between mt-2 group-hover:text-indigo/90">
                <div class="text-gray-500 group-hover:text-indigo/90"><span class="text-lg font-semibold text-gray-900
                 group-hover:text-indigo/90">{{ product.name }}</span>{{ product.display_size ? ', '+product.display_size+'"':'' }}</div>
                <div>{{ product.price }} ₽</div>
            </div>
            <div class="text-gray-500 group-hover:text-indigo/90">{{ product.model }}</div>
        </Link>
    </div>
    <div v-else class="w-full mx-auto p-3 text-center">
        <h3>Нет результатов</h3>
    </div>
    <div v-if="paging" class="w-full mx-auto p-3 justify-right">
        <ul class="flex justify-end [&>*]:mx-1">
            <li v-if="paging.first_page"><Link :href="paging.first_page.url" :class="paging.first_page.active ? 'text-white/90 rounded bg-gray-700 p-2':'p-2'">{{ paging.first_page.label }}</Link></li>
            <li v-if="paging.pages" v-for="page in paging.pages"><Link :href="page.url" :class="page.active ? 'text-white/90 rounded bg-gray-700 p-2':'p-2'">{{ page.label }}</Link></li>
            <li v-if="paging.last_page"><Link :href="paging.last_page.url" :class="paging.last_page.active ? 'text-white/90 rounded bg-gray-700 p-2':'p-2'">{{ paging.last_page.label }}</Link></li>
        </ul>
    </div>
</template>