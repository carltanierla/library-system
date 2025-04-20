<script setup lang="ts">
import type {BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { reactive } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Books Master List',
        href: '/master-list',
    },
];

defineProps({ books: Object})

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
    <Head title="Books Master List" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <div class="relative overflow-x-auto overflow-y-auto">
                    <table class="table-auto w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 md:table-auto">
                        <thead class="text-xs text-gray-700 uppercase bg-sidebar dark:bg-gray-800 dark:text-gray-400">
                        <tr>
                            <th v-for="(header, index) in headers" :key="index" scope="col" :class="{'dark:bg-sidebar': index % 2 === 0, 'dark:bg-gray-800': index % 2 !== 0}" class="px-6 py-3 dark:text-white">
                                {{ header }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr  v-for="book in books?.data" :key="book.book_id" class="bg-white border-b dark:bg-sidebar dark:border-gray-700 border-gray-200">
                            <td scope="row" class="px-3 py-2.5 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ book.book_id }}
                            </td>
                            <td class="px-3 py-2.5 font-medium text-gray-900 dark:text-white dark:bg-gray-800 w-1/2">
                                {{ book.title }}
                            </td>
                            <td class="px-3 py-2.5 font-medium text-gray-900 dark:text-white">
                                {{ book.author }}
                            </td>
                            <td class="px-3 py-2.5 font-medium text-gray-900 dark:text-white dark:bg-gray-800">
                                {{ book.year }}
                            </td>
                            <td class="px-3 py-2.5 font-medium text-gray-900 dark:text-white">
                                {{ book.strand }}
                            </td>
                            <td class="px-3 py-2.5 font-medium text-gray-900 dark:text-white dark:bg-gray-800">
                                {{ book.reference }}
                            </td>
                            <td class="px-3 py-2.5 font-medium text-gray-900 dark:text-white">
                                {{ book.category }}
                            </td>
                            <td class="px-3 py-2.5 font-medium text-gray-900 dark:text-white dark:bg-gray-800">
                                {{ book.track }}
                            </td>
                            <td class="px-3 py-2.5 font-medium text-gray-900 dark:text-white">
                                {{ book.type }}
                            </td>
                            <td class="px-3 py-2.5 font-medium text-gray-900 dark:text-white dark:bg-gray-800">
                                {{ book.status }}
                            </td>
                            <td class="px-3 py-2.5 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <Link :href="`/books/${book.book_id}/edit`">EDIT</Link>
                                <Link :href="`/books/${book.book_id}/edit`">EDIT</Link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="flex items-center justify-between border-t border-gray-200 dark:bg-gray-800 dark:white px-4 py-3 sm:px-6">

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
                                    <Component v-for="(link, index) in books?.links" :key="index">
                                    <Link v-if="link.url" :href="link.url" :class="{'bg-gray-500': link.active}" class="relative font-semibold inline-flex items-center px-4 py-2 text-sm text-gray-900 dark:text-white ring-1 ring-gray-300 ring-inset hover:bg-gray-500 focus:z-20 focus:outline-offset-0">
                                        <span  v-html="link.label"></span>
                                    </Link>
                                        <span v-else v-html="link.label" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 dark:text-gray-500 ring-1 ring-gray-300 ring-inset"></span>
                                    </Component>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </AppLayout>
</template>
