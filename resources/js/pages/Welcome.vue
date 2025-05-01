<script setup lang="ts">
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

defineProps( {
    books: Array
})

const getImage = (image) => {
    return new URL(`/resources/images/book_images/${image}`, import.meta.url).href
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Home',
        href: '/',
    },
];
</script>

<template>
    <Head title="Home" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid grid-rows-1 gap-6 grid-cols-3">
                <div
                    v-for="(book, index) in books" :key="index" class="flex flex-wrap justify-center gap-6 col-span-1 row-span-2 relative">
                    <div

                        class="relative w-full h-100 p-4 border-gray-800 rounded-2xl shadow-lg card transition-transform duration-300 flex flex-col items-center">
                        <div class="border-animation"></div>
                        <div class="card-content">
                            <img :src="getImage(book.image)" alt="" class="w-56 h70 rounded-lg object-cover">
                            <h2 class="mt-3 text-xl font-bold text-white">{{ book.title }}</h2>
                            <div class="flex">
                            <p class="text-gray-300 mx-2">{{ book.author }}</p>
                            <p class="text-gray-300 mx-2">{{ book.year }}</p>
                            </div>
                            <div class="flex">
                                <span class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-blue-900 dark:text-blue-300">{{ book.strand }}</span>
                                <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300">{{ book.category }}</span>
                                <span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">{{ book.track }}</span>
                                <span class="bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-yellow-900 dark:text-yellow-300">{{ book.type }}</span>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between items-center w-full px-4">
                            <span class="text-yellow-400 font-bold">Availability: {{ book.status }}</span>
                            <span v-if="book.status === 'available'" class="text-red-400 font-bold">
                                <button type="button" class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Borrow</button>
                            </span>
                            <span v-if="book.status === 'borrowed'" class="text-red-400 font-bold">
                                <button type="button" class="text-white bg-red-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Return</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.card {
    position: relative;
    border: 2px solid transparent;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(63, 255, 236, 0.3);
}

.card .border-animation {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    border: 2px solid transparent;
    pointer-events: none;
    transition: all 0.5s ease;
}

.card:hover .border-animation {
    border-radius: 10px;
}

.img {
    user-select: none;
    pointer-events: none;
}

.card-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    flex-grow: 1;
}

</style>
