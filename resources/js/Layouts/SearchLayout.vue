<script setup>
import { useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import InputValue from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    search: {
        type: String,
        default: '',
    }
});

const form = useForm({
    searching: null
});
onMounted(() => {
    form.searching = props.search;
});
</script>

<template>
    <div class="max-w-7xl mx-auto p-3">
        <form @submit.prevent="form.get(route('search'), {preserveState: true})" class="flex justify-between items-center">
            <InputValue value="Поиск" />
            <input 
                type="text" 
                v-model="form.searching"
                class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700
                    uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2
                    focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150
                    h-12 w-full mx-4"
                value=""
                placeholder="поиск в каталоге"
            />
            <PrimaryButton type="submit" :disabled="form.processing">
                Найти
            </PrimaryButton>
        </form>
    </div>
</template>