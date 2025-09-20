<script setup>
import { ref, toRefs, reactive, computed, onMounted, onBeforeMount, watch } from 'vue';
import { router, usePage, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import VueSlider from 'vue-3-slider-component'

const props = defineProps({
    catalog: {
        type: String
    },
    catalogStats: {
        type: Object
    },
    filters: {
        type: Object
    }
});


const form = useForm({
   brands: [],
   price: [],
   catalog: null,
});

const openPage = function (type) {
    router.visit(route('home'), {data: {catalog: type}})
}

let isCheckAll = ref(false), prices = ref([]), filterButton = ref(false);

const checkAll = function () {
    filterButton.value = true;
    isCheckAll.value = !isCheckAll.value;
    if (isCheckAll.value == true) {
        form.brands = [];
        if (props.catalog == 'phones') {
            props.catalogStats.phonesBrands.forEach((num, i, value) => {
                form.brands.push(value[i].key);
            });
        } else if (props.catalog == 'tablets') {
            props.catalogStats.tabletsBrands.forEach((num, i, value) => {
                form.brands.push(value[i].key);
            });
        } else if (props.catalog == 'parts') {
            props.catalogStats.partsBrands.forEach((num, i, value) => {
                form.brands.push(value[i].key);
            });
        }
    } else {
        form.brands = [];
    }
}

onMounted(() => {
    if (props.catalog == 'phones') {
        prices.value = [props.catalogStats.phonesPrices['price_min'], props.catalogStats.phonesPrices['price_max']];
    } else if (props.catalog == 'tablets') {
        prices.value = [props.catalogStats.tabletsPrices['price_min'], props.catalogStats.tabletsPrices['price_max']];
    } else if (props.catalog == 'parts') {
        prices.value = [props.catalogStats.partsPrices['price_min'], props.catalogStats.partsPrices['price_max']];
    } else {
        prices.value = [0, 1000000];
    }
    form.price = prices.value;
    form.catalog = props.catalog;
});
</script>

<template>
    <div class="mt-2 flex flex-col">
        <h2>Каталог</h2>
        <PrimaryButton v-if="catalog == 'phones'" class="h-12 mt-2 w-[200px] justify-center" @click="openPage('phones')">Телефоны ({{ catalogStats.phonesCount }})</PrimaryButton>
        <SecondaryButton v-else class="h-12 mt-2 w-[200px] justify-center" @click="openPage('phones')">Телефоны ({{ catalogStats.phonesCount }})</SecondaryButton>
        <PrimaryButton v-if="catalog == 'tablets'" class="h-12 mt-2 w-[200px] justify-center" @click="openPage('tablets')">Планшеты ({{ catalogStats.tabletsCount }})</PrimaryButton>
        <SecondaryButton v-else class="h-12 mt-2 w-[200px] justify-center" @click="openPage('tablets')">Планшеты ({{ catalogStats.tabletsCount }})</SecondaryButton>
        <PrimaryButton v-if="catalog == 'parts'" class="h-12 mt-2 w-[200px] justify-center" @click="openPage('parts')">Аксессуары ({{ catalogStats.partsCount }})</PrimaryButton>
        <SecondaryButton v-else class="h-12 mt-2 w-[200px] justify-center" @click="openPage('parts')">Аксессуары ({{ catalogStats.partsCount }})</SecondaryButton>
    </div>
    <form @submit.prevent="form.get(route('home'), {preserveState: true})">
    <template v-if="catalog && (catalog == 'phones' || catalog == 'tablets')">
        <div class="mt-2">
            <h2>Бренды</h2>
            <ul>
                <li class="my-1 px-2"><label><input type="checkbox" name="brands" value="all"
                    class="h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-slate-800 checked:border-slate-800"
                    @click="checkAll()"
                    v-model="isCheckAll"
                >
                    Все</input></label></li>
                <li v-for="brand in (catalog == 'phones' ? catalogStats.phonesBrands : catalogStats.tabletsBrands)" :key="brand.key" class="my-1 px-2">
                    <label>
                        <input type="checkbox" :value="brand.key"
                            class="h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-slate-800 checked:border-slate-800"
                            v-model="form.brands"
                            @change="filterButton = true"
                        > {{ brand.key }} ({{ brand.doc_count }})</input>
                    </label>
                </li>
            </ul>
        </div>
    </template>
    <template v-if="catalog && (catalog == 'parts')">
        <div class="mt-2">
            <h2>Категории</h2>
            <ul>
                <li class="my-1 px-2"><label><input type="checkbox" name="brands" value="all"
                    class="h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-slate-800 checked:border-slate-800"
                    @click="checkAll()"
                    v-model="isCheckAll"
                >
                    Все</input></label></li>
                <li v-for="brand in catalogStats.partsBrands" :key="brand.key" class="my-1 px-2">
                    <label>
                        <input type="checkbox" :value="brand.key"
                            class="h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-slate-800 checked:border-slate-800"
                            v-model="form.brands"
                            @change="filterButton = true"
                        > {{ brand.key }} </input>
                    </label>
                </li>
            </ul>
        </div>
    </template>
    <div class="mt-2 w-[200px]">
        <h2>Цена</h2>
        <VueSlider 
            v-model="form.price"
            @change="(v, i) => { filterButton = true; }"
            tooltip="always"
            :interval="100"
            :min="prices[0] ?? 0"
            :max="prices[1] ?? 10000000"
            :contained="true"
            :dotStyle="{backgroundColor:'gray', boxShadow: '0 0 !important'}"
            :railStyle="{backgroundColor:'#cfcfcf'}"
            :processStyle="{backgroundColor:'gray'}"
            :tooltipStyle="{color: '#fff', backgroundColor:'gray', boxShadow: '0 0 !important', borderTopColor: 'gray'}"
            :style="{ 'background-color': 'transparent' }"
            class="mt-16 px-2"
        />
    </div>
    <div class="w-[200px] m-auto mt-6">
        <PrimaryButton v-if="filterButton">найти</PrimaryButton>
        <SecondaryButton v-else disabled>найти</SecondaryButton>
    </div>
    </form>
</template>