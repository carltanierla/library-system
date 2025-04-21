<script setup lang="ts">
import { Check } from 'lucide-vue-next'

defineProps({
    message: String,
})
</script>

<template>
    <div class="fixed top-5 right-5 w-80">
        <div id="toast-default" class="flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-white dark:bg-green-700" role="alert">
            <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500-500 bg-green-700-100 rounded-full dark:bg-green-900-100 dark:text-green-500-500">
                <Check />
                <span class="sr-only">Check icon</span>
            </div>
            <div class="ms-3 text-sm font-normal">{{ message }}</div>
        </div>
    </div>
</template>

