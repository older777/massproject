<script setup>
import { Head } from '@inertiajs/vue3';
import Menu from '@/Layouts/MenuLayout.vue';

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
</script>

<template>
    <Head title="Контакты" />

    <div class="relative min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <Menu :canLogin="canLogin" :canRegister="canRegister" />
        <div class="max-w-6xl m-auto">
            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="sm:w-auto w-full">
                    <div class="font-semibold h-8">Адрес</div>
                    <div class="text-gray-700 h-8">Москва, ул. Тестовая, д. 123</div>
                    <div class="text-gray-700 h-8">т +7 (495) 123-45-67</div>
                </div>
            </div>
            <div class="flex justify-center mt-16 px-6 sm:items-center sm:justify-between">
                <div class="ms-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-end sm:ms-0 mx-2">
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </div>
            </div>
        </div>
    </div>
</template>