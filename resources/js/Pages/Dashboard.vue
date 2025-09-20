<script setup>
import { ref, computed, onMounted, onBeforeUnmount, onBeforeMount } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import { useStore } from 'vuex';

const props = defineProps({
    orders: {
        type: Object,
        required: false,
    }
});

const formUpdate = useForm({
    id: '',
    status: true,
    comment: '',
});

const submitUpdate = async () => {
    formUpdate.clearErrors();
    formUpdate.processing = true;
    await axios.put(route('order.update', {id: formUpdate.id}), formUpdate)
        .then((resp) => { showSuccess(resp.data.messageSuccess); })
        .catch(function (error) {
            formUpdate.processing = false;
            if (error.response) {
                showError(error.response.data);
            };
         });
    formUpdate.processing = false;
};
const store = useStore();
const 
    show = ref(false), 
    modalData = ref({}), 
    messageSuccess = ref(''), 
    messageError = ref(''),
    sortBy = ref('id');
const setCurrentID =  (id) => {
    formUpdate.clearErrors();
    modalData.value = {
        id: props.orders[id].id,
        name: props.orders[id].name,
        email: props.orders[id].email,
        message: props.orders[id].message,
    };
    formUpdate.status = true;
    formUpdate.id = modalData.value.id;
    show.value = true;
};
const enableSubmit = computed( () => {
    if (formUpdate.processing) {
        return true;
    } else {
        return ! formUpdate.status;
    }
});
const onAfterMessage = () => {
    setTimeout(() => {messageSuccess.value = ''; messageError.value = '';}, '3000');
};
const showSuccess = (message) => {
    messageSuccess.value = message;
    if (message) {
        formUpdate.reset();
    }
};
const showError = (message) => {
    if (typeof message.messageError !== 'undefined') {
        messageError.value = message.messageError;
    } else {
        messageError.value = message.message;
        if (message.errors.status) {
            formUpdate.setError('status', message.errors.status[0]);
        };
        if (message.errors.comment) {
            formUpdate.setError('comment', message.errors.comment[0]);
        };
    }
};
const loadOrders = () => {
    let loadURL = route('dashboard');
    if (sortBy.value) {
        loadURL = route('dashboard') + `?sort=${sortBy.value}`;
    };
    router.visit(loadURL, { only: ['orders'] });

};
onMounted( () => {
    if (typeof props.orders === 'undefined') {
        loadOrders();
    }
});
onBeforeUnmount(() => {
    store.state.data.sortBy = sortBy;
});

onBeforeMount(() => {
    if (typeof store.state.data.sortBy !== 'undefined') {
        sortBy.value = store.state.data.sortBy;
    }
});
</script>

<template>
    <Head title="Личный кабинет" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Данные тикетов</h2>
        </template>
        
        <Modal :show="show" :maxWidth="'xl'">
            <form @submit.prevent="submitUpdate" class="w-full mx-4 my-2">
                <div>Имя: {{ modalData.name }}</div>
                <div>Email: {{ modalData.email }}</div>
                <div class="mb-4">Сообщение: {{ modalData.message }}</div>
                <InputLabel for="message" value="Введите ответ" />
                <TextArea name="comment" v-model="formUpdate.comment" class="!w-3/4" />
                <div v-if="formUpdate.errors.comment" class="text-red-500">{{ formUpdate.errors.comment }}</div>
                <input type="checkbox" id="status" name="status" v-model="formUpdate.status" :checked="formUpdate.status" />
                <InputLabel for="status" value="решено" class="inline-block ml-1 w-3/4" />
                <div v-if="formUpdate.errors.status" class="text-red-500">{{ formUpdate.errors.status }}</div>
                <input type="hidden" name="id" :value="modalData.id">
                <PrimaryButton 
                    type="submit"
                    class="mt-2 mr-2 disabled:pointer-events-none disabled:bg-gray-300"
                    :disabled="enableSubmit">
                    Отправить
                </PrimaryButton>
                <SecondaryButton class="mt-2" @click="() => { loadOrders(); show = false;}">Закрыть</SecondaryButton>
                <div class="h-16 w-3/4">
                    <Transition @after-enter="onAfterMessage" name="message">
                        <div v-if="messageSuccess" class="my-4 px-12 absolute bg-green-300 w-auto py-2 text-green-900 border border-green-700">{{ messageSuccess }}</div>
                    </Transition>
                    <Transition @after-enter="onAfterMessage" name="message">
                        <div v-if="messageError" class="my-4 px-12 absolute bg-pink-300 w-auto py-2 text-red-900 border border-red-700" @after-enter="onAfterMessage">{{ messageError }}</div>
                    </Transition>
                </div>
            </form>
        </Modal>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <PrimaryButton 
                            type="submit"
                            class="m-2 mb-4"
                            :class="{'!bg-gray-500' : sortBy == 'id'}"
                            @click="() => {sortBy = 'id'; loadOrders();}">
                            Сортировка по ID
                        </PrimaryButton>
                        <PrimaryButton 
                            type="submit"
                            class="m-2 mb-4"
                            :class="{'!bg-gray-500' : sortBy == 'status'}"
                            @click="() => {sortBy = 'status'; loadOrders();}">
                            Сортировка по статусу
                        </PrimaryButton>
                        <PrimaryButton 
                            type="submit"
                            class="m-2 mb-4"
                            :class="{'!bg-gray-500' : sortBy == 'updated_at'}"
                            @click="() => {sortBy = 'updated_at'; loadOrders();}">
                            Сортировка по дате обновления
                        </PrimaryButton>
                        <table class="text-sm">
                            <thead>
                                <tr>
                                    <th>ID</th><th>Имя</th><th>Email</th><th>Сообщение</th><th>Статус</th><th>Комментарий оператора</th><th>Создано</th><th>Обновлено</th><th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(order, index) in orders" :key="order.id" class="[&>td]:px-4 [&>td]:py-2 [&>td]:hover:bg-green-100">
                                    <td>{{ order.id }}</td>
                                    <td>{{ order.name }}</td>
                                    <td>{{ order.email }}</td>
                                    <td>{{ order.message }}</td>
                                    <td>{{ order.status }}</td>
                                    <td>{{ order.comment }}</td>
                                    <td>{{ order.created_at }}</td>
                                    <td>{{ order.updated_at }}</td>
                                    <td><svg v-if="order.status  == 'Active'" @click="setCurrentID(index)" class="h-4 cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 121.51"><title>Нажмите для управления</title><path d="M28.66,1.64H58.88L44.46,16.71H28.66a13.52,13.52,0,0,0-9.59,4l0,0a13.52,13.52,0,0,0-4,9.59v76.14H91.21a13.5,13.5,0,0,0,9.59-4l0,0a13.5,13.5,0,0,0,4-9.59V77.3l15.07-15.74V92.85a28.6,28.6,0,0,1-8.41,20.22l0,.05a28.58,28.58,0,0,1-20.2,8.39H11.5a11.47,11.47,0,0,1-8.1-3.37l0,0A11.52,11.52,0,0,1,0,110V30.3A28.58,28.58,0,0,1,8.41,10.09L8.46,10a28.58,28.58,0,0,1,20.2-8.4ZM73,76.47l-29.42,6,4.25-31.31L73,76.47ZM57.13,41.68,96.3.91A2.74,2.74,0,0,1,99.69.38l22.48,21.76a2.39,2.39,0,0,1-.19,3.57L82.28,67,57.13,41.68Z"/></svg></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
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
