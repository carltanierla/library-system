<script setup lang="ts">
import type {BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';
import Button from '../components/ui/button/Button.vue';
import { Plus } from 'lucide-vue-next';
import ToastMessage from '@/components/ToastMessage.vue';
import BooksTable from '@/components/BooksTable.vue';
import BookSearch from '@/components/BookSearch.vue';
import BookFormModal from '@/components/BookFormModal.vue';
import DeleteConfirmationModal from '@/components/DeleteConfirmationModal.vue';

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

let toastMessage = ('');
const isModalOpen = ref(false);
const isDeleteConfirmModalOpen = ref(false);
const isToastOpen = ref(false);
const isEditMode = ref(false)
const bookEditValues = ref({});
const form = useForm({
    book_id: '' as string | number
})

const setToastMessage = (message: string) => {
    isToastOpen.value = true;
    toastMessage = message;
    setTimeout(() => {
        isToastOpen.value = false
    },5000)

}
const handleAddModalClick = () => {
    bookEditValues.value = {};
    isModalOpen.value = true;
    isEditMode.value = false;
}
const handleEditClicked = (data: object) => {
    isEditMode.value = true;
    bookEditValues.value = data;
    isModalOpen.value = true;
}
const handleDeleteClicked = (book_id: number) => {
    form.book_id = book_id;
    isDeleteConfirmModalOpen.value = true;
}
const handleCancelDeleteClick = () => {
    isDeleteConfirmModalOpen.value = false;
    form.reset();
}
const handleConfirmDeleteClicked = () => {
    form.delete(route('delete-book', form.book_id), {
        preserveScroll: true,
        onSuccess: () => {
            setToastMessage('Book Deleted Successfully');
            isDeleteConfirmModalOpen.value = false;
            form.reset();
        }
    });
}
</script>


<template>
    <Head title="Books Master List" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-4 rounded-xl">
            <div class="relative min-h-[100vh] flex-1 overflow-x-auto overflow-y-auto rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min flex flex-col justify-between my-1">
                <div class="w-full flex justify-between">
                    <Button @click="handleAddModalClick" data-sidebar="trigger" variant="secondary" size="lg" class="dark:hover:bg-gray-600 bg-gray-700 text-gray-50 hover:bg-gray-400 border border-gray-500 rounded-lg justify-start my-1 py-5 text-center dark:bg-gray-700">
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
                <BooksTable
                    :books="books"
                    @editClicked="handleEditClicked"
                    @deleteClicked="handleDeleteClicked"
                />
            </div>
        </div>
        <transition name="modal">
            <BookFormModal
                v-if="isModalOpen"
                @closeModal="isModalOpen = false"
                @successFormSubmit="setToastMessage"
                :bookEditValues="bookEditValues"
                :isEditMode="isEditMode"
            />
        </transition>

        <transition name="modal">
            <DeleteConfirmationModal
                v-if="isDeleteConfirmModalOpen"
                @cancelClicked="handleCancelDeleteClick"
                @confirmDeleteClicked="handleConfirmDeleteClicked"
            />
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
