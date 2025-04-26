<script setup lang="ts">

import { Link } from '@inertiajs/vue3';
import { reactive } from 'vue';

defineProps({
    borrow_history: Object,
})

const headers = reactive([
    'Book Title',
    'borrower Name',
    'borrower Section',
    'Borrow Date',
    'Return Date',
]);
</script>

<template>
    <table class="table-auto flex-1 w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 md:table-auto">
        <thead class="text-xs text-gray-700 uppercase bg-sidebar dark:bg-gray-800 dark:text-gray-400">
        <tr>
            <th v-for="(header, index) in headers" :key="index" scope="col" :class="{'dark:bg-sidebar': index % 2 === 0, 'dark:bg-gray-800': index % 2 !== 0}" class="px-6 py-3 dark:text-white">
                {{ header }}
            </th>
        </tr>
        </thead>
        <tbody>
        <tr v-if="borrow_history?.data < 1">
            <td colspan="12" rowspan="1" class="px-3 py-2.5 text-3xl font-bold text-gray-900 dark:text-white text-center">No Data Available</td>
        </tr>
        <tr v-else v-for="borrower in borrow_history?.data" :key="borrower.borrower_id" class="bg-white border-b dark:bg-sidebar dark:border-gray-700 border-gray-200">
            <td rowspan="1" class="text-center px-3 py-2.5 font-medium text-gray-900 dark:text-white dark:bg-gray-800">
                {{ borrower.books.title }}
            </td>
            <td rowspan="1" class="text-center px-3 py-2.5 font-medium text-gray-900 dark:text-white">
                {{ borrower.borrower_name }}
            </td>
            <td rowspan="1" class="text-center px-3 py-2.5 font-medium text-gray-900 dark:text-white dark:bg-gray-800">
                {{ borrower.borrower_section }}
            </td>
            <td rowspan="1" class="text-center px-3 py-2.5 font-medium text-gray-900 dark:text-white">
                {{ borrower.borrowed_at }}
            </td>
            <td rowspan="1" class="text-center px-3 py-2.5 font-medium text-gray-900 dark:text-white dark:bg-gray-800">
                {{ borrower.returned_at }}
            </td>
        </tr>
        </tbody>
    </table>
    <div class="flex border-t border-gray-200 dark:bg-gray-800 dark:white px-4 py-3 sm:px-6">

        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700 dark:text-white">
                    Showing
                    {{ ' ' }}
                    <span class="font-medium">{{ borrow_history?.from }}</span>
                    {{ ' ' }}
                    to
                    {{ ' ' }}
                    <span class="font-medium">{{ borrow_history?.to }}</span>
                    {{ ' ' }}
                    of
                    {{ ' ' }}
                    <span class="font-medium">{{ borrow_history?.total }}</span>
                    {{ ' ' }}
                    results
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-xs" aria-label="Pagination">
                    <template v-for="(link, index) in borrow_history?.links" :key="index">
                        <Link v-if="link.url" :href="link.url" :class="{'bg-gray-700 text-white dark:bg-gray-300 dark:text-gray-900': link.active}" class="relative font-semibold inline-flex items-center px-4 py-2 text-sm text-gray-900 dark:text-white ring-1 ring-gray-300 ring-inset hover:bg-gray-500 focus:z-20 focus:outline-offset-0">
                            <span  v-html="link.label"></span>
                        </Link>
                        <span v-else v-html="link.label" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 dark:text-gray-500 ring-1 ring-gray-300 ring-inset"></span>
                    </template>
                </nav>
            </div>
        </div>
    </div>
</template>
