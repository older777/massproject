<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    product: {
        type: Object,
    }
});
</script>

<template>
    <a href="#" onclick="history.back();return false;" class="my-2 px-2 text-cyan-900">Назад</a>
    <div class="flex w-full">
        <div class="p-2 w-1/2">
            <img :src="product.photo">
        </div>
        <div class="p-2 w-1/2">
            <div class="mb-2 text-xl">
                {{ product.type == 'phones' ? 'Телефон' : product.type == 'tablets' ? 'Планшет' : '' }}
                {{ product.name }}, {{ product.model }}
            </div>
            <div class="mb-2 text-2xl">
                {{ product.price }} ₽
            </div>
            <div v-if="product.display_size" class="mb-2 text-gray-500">
                Дисплей, {{ product.display_size }}"
            </div>
            <div v-if="product.color" class="mb-2 text-gray-500">
                Цвет, {{ product.color }}
            </div>
            <div v-if="product.processor" class="mb-2 text-gray-500">
                Процессор, {{ product.processor }}
            </div>
            <div v-if="product.storage" class="mb-2 text-gray-500">
                Размер накопителя, {{ product.storage }}
            </div>
            <div v-if="product.size" class="mb-2 text-gray-500">
                Размеры, {{ product.size }}
            </div>
            <div v-if="product.ram" class="mb-6 text-gray-500">
                Размер ОЗУ, {{ product.ram }}
            </div>
            <div v-if="product.weight" class="mb-6 text-gray-500">
                Вес (кг), {{ product.weight }}
            </div>
            <PrimaryButton>Купить</PrimaryButton>
        </div>
    </div>
</template>