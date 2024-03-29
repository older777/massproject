<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { onBeforeUnmount, onBeforeMount, ref } from 'vue';
import { useStore } from 'vuex';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';

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
const messageSuccess = ref(''), messageError = ref('');
const store = useStore();
const orderForm = useForm({
    name: '',
    email: '',
    message: '',
});
const submitOrder = async () => {
    orderForm.clearErrors();
    orderForm.processing = true;
    await axios.post(route('submit.order'), orderForm)
        .then((resp) => { showSuccess(resp.data.messageSuccess); })
        .catch(function (error) {
            if (error.response) {
                showError(error.response.data);
            };
         });
    orderForm.processing = false;
};

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

const onAfterMessage = () => {
    setTimeout(() => {messageSuccess.value = ''; messageError.value = '';}, '3000');
};

onBeforeUnmount(() => {
    store.state.data.orderForm = orderForm;
});

onBeforeMount(() => {
    if (typeof store.state.data.orderForm !== 'undefined') {
        orderForm.name = store.state.data.orderForm.name;
        orderForm.email = store.state.data.orderForm.email;
        orderForm.message = store.state.data.orderForm.message;
    }
});
</script>

<template>
    <Head title="Создать заявку" />

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
    >
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Dashboard</Link
            >

            <template v-else>
                <Link
                    :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Log in</Link
                >

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Register</Link
                >
            </template>
        </div>

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                
            </div>

            <div class="mt-2 w-full">
                <h1 class="text-center">Создать заявку</h1>
                <div class="mt-4 w-full p-2 overscroll-contain">
                    <form @submit.prevent="submitOrder">
                        <InputLabel for="name" value="Имя" />
                        <TextInput type="text" name="name" v-model="orderForm.name" />
                        <div v-if="orderForm.errors.name" class="text-red-500">{{ orderForm.errors.name }}</div>
                        <InputLabel for="email" value="Email" />
                        <TextInput type="email" name="email" v-model="orderForm.email" required />
                        <div v-if="orderForm.errors.email" class="text-red-500">{{ orderForm.errors.email }}</div>
                        <InputLabel for="message" value="Введите сообщение" />
                        <TextArea name="message" v-model="orderForm.message" />
                        <div v-if="orderForm.errors.message" class="text-red-500">{{ orderForm.errors.message }}</div>
                        <PrimaryButton type="submit" class="mt-2 mr-2 disabled:pointer-events-none disabled:bg-gray-300" @click.prevent="submitOrder" :disabled="orderForm.processing">создать</PrimaryButton>
                        <SecondaryButton class="mt-2" @click="() => { orderForm.reset(); orderForm.clearErrors(); }">отменить</SecondaryButton>
                    </form>
                    <Transition @after-enter="onAfterMessage" name="message">
                        <div v-if="messageSuccess" class="my-4 px-12 absolute bg-green-300 w-auto py-2 text-green-900 border border-green-700">{{ messageSuccess }}</div>
                    </Transition>
                    <Transition @after-enter="onAfterMessage" name="message">
                        <div v-if="messageError" class="my-4 px-12 absolute bg-pink-300 w-auto py-2 text-red-900 border border-red-700" @after-enter="onAfterMessage">{{ messageError }}</div>
                    </Transition>
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
