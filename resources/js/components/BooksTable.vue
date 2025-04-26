<script setup lang="ts">

import { Link } from '@inertiajs/vue3';
import { reactive } from 'vue';

defineProps( {
    books: Object
})

const headers = reactive([
    'book id',
    'title',
    'author',
    'year',
    'strand',
    'reference',
    'category',
    'track',
    'type',
    'status',
    'Actions'
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
        <tr v-if="books?.data < 1">
            <td colspan="12" rowspan="1" class="px-3 py-2.5 text-3xl font-bold text-gray-900 dark:text-white text-center">No Data Available</td>
        </tr>
        <tr v-else v-for="book in books?.data" :key="book.book_id" class="bg-gray-100 border-b dark:bg-sidebar dark:border-gray-700 border-gray-200">
            <td rowspan="1" class="px-3 py-2.5 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ book.book_id }}
            </td>
            <td rowspan="1" class="px-3 py-2.5 font-medium text-gray-900 dark:text-white dark:bg-gray-800">
                {{ book.title }}
            </td>
            <td rowspan="1" class="px-3 py-2.5 font-medium text-gray-900 dark:text-white">
                {{ book.author }}
            </td>
            <td rowspan="1" class="px-3 py-2.5 font-medium text-gray-900 dark:text-white dark:bg-gray-800">
                {{ book.year }}
            </td>
            <td rowspan="1" class="px-3 py-2.5 font-medium text-gray-900 dark:text-white">
                {{ book.strand }}
            </td>
            <td rowspan="1" class="px-3 py-2.5 font-medium text-gray-900 dark:text-white dark:bg-gray-800">
                {{ book.reference }}
            </td>
            <td rowspan="1" class="px-3 py-2.5 font-medium text-gray-900 dark:text-white">
                {{ book.category }}
            </td>
            <td rowspan="1" class="px-3 py-2.5 font-medium text-gray-900 dark:text-white dark:bg-gray-800">
                {{ book.track }}
            </td>
            <td rowspan="1" class="px-3 py-2.5 font-medium text-gray-900 dark:text-white">
                {{ book.type }}
            </td>
            <td rowspan="1" class="px-3 py-2.5 font-medium text-gray-900 dark:text-white dark:bg-gray-800">
                {{ book.status }}
            </td>
            <td rowspan="1" class="py-2.5 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                <Link :href="`/books/${book.book_id}/edit`" class="mx-1">EDIT</Link>
                <Link :href="`/books/${book.book_id}/edit`" class="mx-1">DELETE</Link>
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
                    <span class="font-medium">{{ books?.from }}</span>
                    {{ ' ' }}
                    to
                    {{ ' ' }}
                    <span class="font-medium">{{ books?.to }}</span>
                    {{ ' ' }}
                    of
                    {{ ' ' }}
                    <span class="font-medium">{{ books?.total }}</span>
                    {{ ' ' }}
                    results
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-xs" aria-label="Pagination">
                    <template v-for="(link, index) in books?.links" :key="index">
                        <Link v-if="link.url" :href="link.url" :class="{'bg-gray-700 text-white dark:bg-gray-300 dark:text-gray-900': link.active}" class="relative font-semibold inline-flex items-center px-4 py-2 text-sm text-gray-900 dark:text-white ring-1 ring-gray-300 ring-inset hover:bg-gray-500 hover:text-white focus:z-20 focus:outline-offset-0">
                            <span  v-html="link.label"></span>
                        </Link>
                        <span v-else v-html="link.label" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 dark:text-gray-500 ring-1 ring-gray-300 ring-inset"></span>
                    </template>
                </nav>
            </div>
        </div>
    </div>
</template>
