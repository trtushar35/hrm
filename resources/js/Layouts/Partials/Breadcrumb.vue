<script setup>

import { Head, Link, router } from '@inertiajs/vue3';
defineProps(['breadcrumbs']);

</script>
<template>
    <header v-if="breadcrumbs" class="duration-1000 bg-white rounded-md dark:bg-slate-900 shadow-md shadow-gray-800/50">
        <div class="px-4 py-2">
            <ul class="flex items-center space-x-2">
                <template v-for="breadcrumb, breadcrumbIndex in breadcrumbs" :key="breadcrumb.title">
                    <li>
                        <Link v-if="breadcrumb.link" :href="breadcrumb.link"
                            class="text-sm font-semibold leading-tight transition duration-1000 ease-in-out text-slate-900 dark:text-slate-300">
                        {{
                            breadcrumb.title }}</Link>
                            <a href="javascript:void(0)" v-else class="text-sm font-semibold leading-tight transition duration-1000 ease-in-out text-slate-900 dark:text-slate-300">{{ breadcrumb.title }}</a>
                    </li>
                    <li class="text-sm text-gray-500 dark:text-gray-400"
                        v-if="breadcrumbIndex != (parseInt(breadcrumbs?.length ?? 0) - 1)">/</li>
                </template>
            </ul>
        </div>
    </header>
</template>
