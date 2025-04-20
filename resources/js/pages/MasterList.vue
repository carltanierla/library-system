<script setup lang="ts">
import type {BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { reactive, ref, watch } from 'vue';
import Button from '../components/ui/button/Button.vue';
import { Plus } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Books Master List',
        href: '/master-list',
    },
];

const props = defineProps({
    books: Object,
    filters: Object
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

const form = useForm({
    search: props.filters?.search
})

let isModalOpen = ref(false)


watch(() => form.search!, () => {
    form.get('/master-list', {
        preserveState: true,
        preserveScroll: true,
        replace: true
    })
})
</script>


<template>
    <Head title="Books Master List" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-4 rounded-xl">
            <div class="relative min-h-[100vh] flex-1 overflow-x-auto overflow-y-auto rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min flex flex-col justify-between my-1">
                <div class="w-full flex justify-between">
                    <Button @click="isModalOpen = !isModalOpen" data-sidebar="trigger" variant="secondary" size="lg" class="border border-gray-500 rounded-lg justify-start my-1 py-5 text-center">
                        <span>Add Book</span>
                        <Plus />
                    </Button>
                    <div class="flex">
                        <form class="max-w-sm mx-2">
                            <select id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>Choose Filter Option</option>
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                                <option value="FR">France</option>
                                <option value="DE">Germany</option>
                            </select>
                        </form>
                        <div class="max-w-sm mx-2 flex-none">
                            <input v-model="form.search" type="text" id="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search..." required />
                        </div>
                    </div>
                </div>
                <table class="table-auto flex-1 w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 md:table-auto">
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
                        <td class="px-3 py-2.5 font-medium text-gray-900 dark:text-white dark:bg-gray-800">
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
                                    <Link v-if="link.url" :href="link.url" :class="{'bg-gray-500': link.active}" class="relative font-semibold inline-flex items-center px-4 py-2 text-sm text-gray-900 dark:text-white ring-1 ring-gray-300 ring-inset hover:bg-gray-500 focus:z-20 focus:outline-offset-0">
                                        <span  v-html="link.label"></span>
                                    </Link>
                                    <span v-else v-html="link.label" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 dark:text-gray-500 ring-1 ring-gray-300 ring-inset"></span>
                                </template>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="isModalOpen" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!--
              Background backdrop, show/hide based on modal state.

              Entering: "ease-out duration-300"
                From: "opacity-0"
                To: "opacity-100"
              Leaving: "ease-in duration-200"
                From: "opacity-100"
                To: "opacity-0"
            -->
            <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <!--
                      Modal panel, show/hide based on modal state.

                      Entering: "ease-out duration-300"
                        From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        To: "opacity-100 translate-y-0 sm:scale-100"
                      Leaving: "ease-in duration-200"
                        From: "opacity-100 translate-y-0 sm:scale-100"
                        To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    -->
                    <div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 dark:bg-gray-800">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                                    <svg class="size-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-base font-semibold text-gray-900" id="modal-title">Deactivate account</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">Are you sure you want to deactivate your account? All of your data will be permanently removed. This action cannot be undone.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 dark:bg-gray-800">
                            <button type="button" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto">Deactivate</button>
                            <button  @click="isModalOpen = !isModalOpen" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
