<script setup lang="ts">

import { Link, Deferred } from '@inertiajs/vue3';
import { reactive } from 'vue';
import Button from './ui/button/Button.vue';

defineProps( {
    books: Object
})

const emit = defineEmits([
    'editClicked',
    'deleteClicked'
])

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

const handleEditClicked = (data) => {
    emit('editClicked', data);
}
const handleDeleteClicked = (book_id) => {
    emit('deleteClicked', book_id);
}

</script>

<template>
    <Deferred data="books">
        <template #fallback>
            <svg aria-hidden="true" class="overflow-hidden w-8 place-self-center text-center justify-self-center justify-center h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
            <span>Processing... </span>
        </template>
        <table class="table-auto flex-1 w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 md:table-auto">
            <thead class="text-center text-xs text-gray-700 uppercase bg-sidebar dark:bg-gray-800 dark:text-gray-400">
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
            <tr v-else v-for="book in books?.data" :key="book.book_id" class="text-center bg-gray-300 border-b dark:bg-sidebar dark:border-gray-700 border-gray-200">
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
                    <Button @click.prevent="handleEditClicked(book)" data-sidebar="trigger" variant="secondary" size="lg" class="dark:hover:bg-gray-600 bg-gray-700 text-gray-50 hover:bg-gray-400 border border-gray-500 rounded-lg mx-1 justify-start text-center dark:bg-gray-700">
                        <span>Edit</span>
                    </Button>
                    <Button @click.prevent="handleDeleteClicked(book.book_id)" data-sidebar="trigger" variant="secondary" size="lg" class="dark:hover:bg-red-400 bg-red-700 text-gray-50 hover:bg-red-400 border border-red-500 rounded-lg mx-1 justify-start text-center dark:bg-red-600">
                        <span>Delete</span>
                    </Button>
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
                            <Link v-if="link.url" :href="link.url" :class="{'bg-gray-700 text-white dark:bg-gray-500 dark:text-gray-900': link.active}" class="relative font-semibold inline-flex items-center px-4 py-2 text-sm text-gray-900 dark:text-white ring-1 ring-gray-300 ring-inset hover:bg-gray-500 hover:text-white focus:z-20 focus:outline-offset-0">
                                <span  v-html="link.label"></span>
                            </Link>
                            <span v-else v-html="link.label" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-gray-500 ring-1 ring-gray-300 ring-inset"></span>
                        </template>
                    </nav>
                </div>
            </div>
        </div>
    </Deferred>
</template>
