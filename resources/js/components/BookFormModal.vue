<script setup lang="ts">
import Button from '../components/ui/button/Button.vue';
import { useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps({
    isEditMode: Boolean,
    bookEditValues: Object
})

const emit = defineEmits([
    'closeModal',
    'successFormSubmit'
])

const form = useForm({
    book_id: '' as number | string,
    title: '' as string,
    author: '' as string,
    year: '' as string,
    strand: '' as string,
    reference: '' as string,
    category: '' as string,
    track: '' as string,
    type: '' as string,

})

const submitForm = () => {
    if (props.isEditMode) {
        form.put(route('update-book', form.book_id), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
                emit('successFormSubmit', 'Book Updated Successfully');
            }
        });
    } else {
        form.post('book/create', {
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
                emit('successFormSubmit', 'Book Created Successfully');
            }
        })
    }
}

const closeModal = () => {
    form.reset();
    emit('closeModal');
}


onMounted(() => {
        form.book_id = props.bookEditValues?.book_id;
        form.title = props.bookEditValues?.title;
        form.author = props.bookEditValues?.author;
        form.year = props.bookEditValues?.year;
        form.strand = props.bookEditValues?.strand;
        form.reference = props.bookEditValues?.reference;
        form.category = props.bookEditValues?.category;
        form.track = props.bookEditValues?.track;
        form.type = props.bookEditValues?.type;
})
</script>

<template>
    <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-950/75 transition-opacity" aria-hidden="true"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 dark:bg-gray-800">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 v-if="isEditMode" class="font-semibold text-4xl text-gray-900 dark:text-white" id="modal-title">Edit Book</h3>
                                <h3 v-else class="font-semibold text-4xl text-gray-900 dark:text-white" id="modal-title">Add Book</h3>
                                <div class="mt-10">
                                    <form @submit.prevent="submitForm">
                                        <div class="mb-6">
                                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Book Title</label>
                                            <textarea v-model="form.title" id="title" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write book title here..." required></textarea>
                                            <div v-if="form.errors.title" v-text="form.errors.title" class="text-red-500 text-xs mt-1"></div>
                                        </div>
                                        <div class="mb-6">
                                            <label for="author" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Author <span class="text-xs">(optional)</span></label>
                                            <input v-model="form.author" type="text" id="author" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Author Name" />
                                            <div v-if="form.errors.author" v-text="form.errors.author" class="text-red-500 text-xs mt-1"></div>
                                        </div>
                                        <div class="mb-6">
                                            <label for="year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Year <span class="text-xs">(optional)</span></label>
                                            <input v-model="form.year" type="number" id="year" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Book Year" />
                                            <div v-if="form.errors.year" v-text="form.errors.year" class="text-red-500 text-xs mt-1"></div>
                                        </div>
                                        <div class="mb-6">
                                            <label for="strand" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Strand <span class="text-xs">(optional)</span></label>
                                            <input v-model="form.strand" type="text" id="strand" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Strand" />
                                            <div v-if="form.errors.strand" v-text="form.errors.strand" class="text-red-500 text-xs mt-1"></div>
                                        </div>
                                        <div class="grid gap-6 mb-6 md:grid-cols-2 my-2">
                                            <div>
                                                <label for="reference" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reference <span class="text-xs">(optional)</span></label>
                                                <input v-model="form.reference" type="text" id="reference" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Reference"/>
                                                <div v-if="form.errors.reference" v-text="form.errors.reference" class="text-red-500 text-xs mt-1"></div>
                                            </div>
                                            <div>
                                                <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category <span class="text-xs">(optional)</span></label>
                                                <input v-model="form.category" type="text" id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Category"/>
                                                <div v-if="form.errors.category" v-text="form.errors.category" class="text-red-500 text-xs mt-1"></div>
                                            </div>
                                            <div>
                                                <label for="track" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Track <span class="text-xs">(optional)</span></label>
                                                <input v-model="form.track" type="text" id="track" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Track"/>
                                                <div v-if="form.errors.track" v-text="form.errors.track" class="text-red-500 text-xs mt-1"></div>
                                            </div>
                                            <div>
                                                <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type <span class="text-xs">(optional)</span></label>
                                                <input v-model="form.type" type="text" id="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Type"/>
                                                <div v-if="form.errors.type" v-text="form.errors.type" class="text-red-500 text-xs mt-1"></div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-3 py-5 sm:flex sm:flex-row-reverse sm:px-6 dark:bg-gray-800">
                                            <Button type="submit" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-blue-700 sm:ml-3 sm:w-auto">Submit</Button>
                                            <Button @click="closeModal" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</Button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

