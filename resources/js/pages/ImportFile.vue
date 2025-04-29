<script setup lang="ts">

import Button from '../components/ui/button/Button.vue';
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Import } from 'lucide-vue-next';
import type { BreadcrumbItem } from '@/types';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Import Excel File',
        href: '/import-excel-file',
    },
];

const successMessage = ref('File imported successfully. Please check the master list page for the newly imported books.');
const isSuccessClassActive = ref(false)
const isFailedClassActive = ref(false)



const form = useForm({
    file: null
})

const getFile = (event: any) => {
    form.file = event!.target!.files[0]
}

const submitForm = () => {
    const fileupload = <HTMLInputElement>document.querySelector('#file_input');
    form.post('book/import', {
        preserveScroll: true,
        onSuccess: () =>  {
            fileupload!.value = '';
            isSuccessClassActive.value = true;
            form.reset();
            setTimeout(() => {
                isSuccessClassActive.value = false;
            },10000)
        },
        onError: () => {
            fileupload!.value = '';
            isFailedClassActive.value = true;
            form.reset();
            setTimeout(() => {
                isFailedClassActive.value = false;
            },5000)
        }
    });
}

</script>

<template>
    <Head title="Import Excel File" />

    <AppLayout :breadcrumbs="breadcrumbs" class="overflow-hidden">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <div class=" flex flex-1 flex-col justify-items-end">
                    <div class="basis-80 flex flex-col">
                        <div class="w-full m-5">
                            <p class="text-3xl m-5">In This Page, You can import Books Via Excel File</p>
                        </div>
                        <transition name="success-message">
                             <span v-if="isSuccessClassActive" class="success-message my-10 mx-10 rounded-2xl p-10 bg-emerald-600 text-2xl text-center text-white-500">
                                 {{ successMessage }}
                             </span>
                        </transition>
                        <transition name="failed-message">
                             <span v-if="form.errors.file && isFailedClassActive" class="failed-message my-10 mx-10 rounded-2xl p-10 bg-red-600 text-2xl text-center text-white-500">
                                 {{ form.errors.file }}
                             </span>
                        </transition>
                    </div>
                     <div class="flex h-1 flex-1 flex-col rounded-xl justify-items-center">
                         <form @submit.prevent="submitForm" class="justify-self-center mt-10">
                             <div class="flex w-full flex-col gap-4 rounded-xl p-4 items-center">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Select Excel File</label>
                                <input class="block w-80 file:px-4 file:py-2 file:bg-gray-700 file:text-white file:border-gray-300 file:rounded-md text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 cursor-pointer dark:text-white focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 hover:file:bg-gray-500" id="file_input" type="file" @input="getFile" required/>
                                 <div v-if="form.progress" role="status" class="flex flex-col justify-between items-center">
                                     <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                         <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                         <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                     </svg>
                                 </div>

                                <Button data-sidebar="trigger" variant="secondary" size="default" class=" justify-self-end mt-2 bg-gray-700 text-white hover:bg-gray-500 dark:text-white">
                                    <span>Import Book</span>
                                    <Import />
                                </Button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.success-message-enter-active,
.success-message-leave-active,
.failed-message-enter-active,
.failed-message-leave-active{
    transition: opacity 3s ease;
}

.success-message-enter-from,
.success-message-leave-to,
.failed-message-enter-from,
.failed-message-leave-to {
    opacity: 0;
}
</style>

