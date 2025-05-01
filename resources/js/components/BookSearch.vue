<script setup lang="ts">

import { useForm } from '@inertiajs/vue3';
import { reactive, watch } from 'vue';
import throttle from 'lodash/throttle'

const props = defineProps({
    filters: Object,
    category: Array,
    track: Array,
    type: Array,
    status: Array
})

const searchForm = useForm({
    search: props.filters?.search,
    category: props.filters?.category ?? null,
    category_value: props.filters?.category_value ?? null
})

const searchFilters = reactive({
    Category: 'category',
    Track: 'track',
    Type: 'type',
    Status: 'status',
})

const getDataByCategoryValue = () => {
    searchForm.get('/master-list', {
        preserveState: true,
        preserveScroll: true,
        replace: true
    })
}

watch(() => searchForm.search!, throttle(() => {
    searchForm.get('/master-list', {
        preserveState: true,
        preserveScroll: true,
        replace: true
    })
}, 1000));

</script>

<template>
    <div class="flex p-1">
        <form class="max-w-sm mx-2">
            <select v-model="searchForm.category" id="filters" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option :value="null">Choose Filter Option</option>
                <option v-for="(value, key , index) in searchFilters" :key="index" :value="value">{{ key }}</option>
            </select>

        </form>
        <form class="max-w-sm mx-2">
            <select v-model="searchForm.category_value" id="filters" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" @change="getDataByCategoryValue">
                <option v-if="searchForm.category" :value="null">Choose Filter Value</option>
                <option v-else  :value="null"><- Choose Filter Option First</option>
                <option v-for="(value, index) in props[searchForm.category]" :key="index" :value="value[searchForm.category]">{{ value[searchForm.category] }}</option>
            </select>
        </form>
        <div class="max-w-sm mx-2 flex-none">
            <input v-model="searchForm.search" type="text" id="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search..." required />
        </div>
    </div>

</template>
