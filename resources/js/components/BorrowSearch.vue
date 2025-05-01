<script setup lang="ts">

import { useForm } from '@inertiajs/vue3';
import { onMounted, watch } from 'vue';
import { initDatepickers } from 'flowbite'
import DateRangePicker from '@/components/DateRangePicker.vue';
import Button from './ui/button/Button.vue';
import { Plus } from 'lucide-vue-next';

const props = defineProps({
    filters: Object,
})

onMounted(() => {
    initDatepickers();
})

const handleChangeStartDate = (start_date: string) => {
    searchForm.start_date = start_date;
}

const handleChangeEndDate = (end_date: string) => {

    searchForm.end_date = end_date;
}

const searchForm = useForm({
    search: props.filters?.search,
    start_date: props.filters?.start_date,
    end_date: props.filters?.end_date,
})

const submitForm = () => {
    searchForm.get('/borrow-history', {
        preserveState: true,
        preserveScroll: true,
        replace: true
    })
}

const submitExcelDownloadForm = () => {
    searchForm.post('/borrow-history/export', {
        preserveState: true,
        preserveScroll: true,
        replace: true
    })
}

watch(() => [searchForm.search, searchForm.start_date, searchForm.end_date], () => {
    submitForm();
},{ deep: true })





</script>

<template>
    <div class="flex flex-1 justify-between p-1">
        <form @submit.prevent="submitExcelDownloadForm" class="justify-self-center" target="_blank">
            <Button data-sidebar="trigger" variant="secondary" size="lg" class="border border-gray-500 rounded-lg justify-start my-1 py-5 text-center dark:bg-gray-700">
                <span>Export Borrow History Result</span>
                <Plus />
            </Button>
        </form>
        <DateRangePicker :start_date="searchForm.start_date"  :end_date="searchForm.end_date" @changeStartDate="handleChangeStartDate" @changeEndDate="handleChangeEndDate"/>
        <div class="max-w-sm mx-2 flex-1 justify-items-end">
            <input v-model="searchForm.search" type="text" id="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search..." required />
        </div>
    </div>
</template>
