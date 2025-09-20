<script setup>
import { Link } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <nav class="w-full bg-white border-b border-gray-100">
        <div class="max-w-6xl flex flex-wrap items-center justify-between mx-auto h-16">
            <div class="space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <Link :href="route('home')">
                    <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                </Link>
            </div>
            <NavLink
                :href="route('home')"
                >Магазин</NavLink>
            <NavLink
                :href="route('ticket')"
                >Тикеты</NavLink>
            <NavLink
                :href="route('contacts')"
                >Контакты</NavLink>
            <template v-if="$attrs.canLogin">
            <NavLink
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                >Личный кабинет</NavLink>
            </template>
            <template v-else>
                <NavLink
                    :href="route('login')"
                    >Войти</NavLink>
                <NavLink
                    v-if="$attrs.canRegister"
                    :href="route('register')"
                    >Регистрация</NavLink>
            </template>
        </div>
    </nav>
</template>