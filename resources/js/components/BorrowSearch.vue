<script setup lang="ts">

import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    filters: Object,
})

const searchForm = useForm({
    search: props.filters?.search,
})
</script>

<template>
    <div class="flex p-1">
        <div class="max-w-sm mx-2 flex">
            <input v-model="searchForm.search" type="text" id="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search..." required />
        </div>
    </div>
</template>
