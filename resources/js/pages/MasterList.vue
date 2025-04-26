<script setup lang="ts">
import type {BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { reactive, ref } from 'vue';
import Button from '../components/ui/button/Button.vue';
import { Plus } from 'lucide-vue-next';
import CreateUserModal from '@/components/CreateUserModal.vue';
import ToastMessage from '@/components/ToastMessage.vue';
import BooksTable from '@/components/BooksTable.vue';
import BookSearch from '@/components/BookSearch.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Books Master List',
        href: '/master-list',
    },
];

defineProps({
    books: Object,
    filters: Object,
    category: Array,
    track: Array,
    type: Array,
    status: Array
})

const isModalOpen = ref(false);
const isToastOpen = ref(false);
let toastMessage = ('');

const setToastMessage = (message: string) => {
    isToastOpen.value = true;
    toastMessage = message;
    setTimeout(() => {
        isToastOpen.value = false
    },5000)

}
</script>


<template>
    <Head title="Books Master List" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-4 rounded-xl">
            <div class="relative min-h-[100vh] flex-1 overflow-x-auto overflow-y-auto rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min flex flex-col justify-between my-1">
                <div class="w-full flex justify-between">
                    <Button @click="isModalOpen = !isModalOpen" data-sidebar="trigger" variant="secondary" size="lg" class="dark:hover:bg-gray-600 bg-gray-700 text-gray-50 hover:bg-gray-400 border border-gray-500 rounded-lg justify-start my-1 py-5 text-center dark:bg-gray-700">
                        <span>Add Book</span>
                        <Plus />
                    </Button>
                    <BookSearch :filters
                                :category
                                :track
                                :type
                                :status
                    />
                </div>
                <BooksTable :books="books"/>
            </div>
        </div>
        <transition name="modal">
            <CreateUserModal v-if="isModalOpen" @closeModal="isModalOpen = false" @successCreateUser="setToastMessage"/>
        </transition>
    </AppLayout>
    <transition name="modal">
        <ToastMessage v-if="isToastOpen" :message="toastMessage"/>
    </transition>
</template>

<style scoped>
.modal-enter-active,
.modal-leave-active{
    transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}
</style>
