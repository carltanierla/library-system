<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import BorrowTable from '@/components/BorrowTable.vue';
import BorrowSearch from '@/components/BorrowSearch.vue';

defineProps({
    borrow_history: Object,
    filters: Object
})

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Books Borrow History',
        href: '/borrow-history',
    },
];


</script>

<template>
    <Head title="Books Borrow History" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-4 rounded-xl">
            <div class="relative min-h-[100vh] h-full flex flex-col place-content-start justify-items-center overflow-x-auto overflow-y-auto rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min my-1">
                <div class="w-full flex flex-row justify-start flex-none">
                    <BorrowSearch :filters="filters"/>
                </div>
                <BorrowTable :borrow_history="borrow_history" />
            </div>
        </div>
    </AppLayout>
</template>
