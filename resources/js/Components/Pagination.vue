<script setup>
import { Link } from '@inertiajs/vue3';
</script>
<template>
    <div class="grid grid-cols-1 gap-4 pt-2 my-4 md:grid-cols-2 justify-items-center">
        <div class="w-full text-center md:text-start">
            <p class="text-sm text-gray-600">
                {{
                    `Displaying ${$page.props.datas?.from ?? 0} to ${$page.props.datas?.to ?? 0} of ${$page.props.datas?.total
                        ?? 0} items`
                }}

            </p>
        </div>
        <nav class="w-full dark:text-gray-50">
            <ul class="flex items-center justify-center space-x-2 md:justify-end">
                <li :class="{ 'disabled': $page.props.datas.links[0].url === null }">
                    <Link :href="$page.props.datas.links[0].url"
                        class="px-3 py-2 transition-colors border border-gray-300 rounded-md cursor-pointer hover:bg-gray-200 focus:outline-none focus:ring focus:border-blue-300"
                        v-if="$page.props.datas.links[0].url" rel="prev">
                    &laquo;
                    </Link>
                    <span v-else class="px-3 py-2 border border-gray-300 rounded-md">&laquo;</span>
                </li>

                <li v-for="link in $page.props.datas.links.slice(1, -1)" :key="link.label">
                    <Link :href="link.url"
                        class="px-3 py-2 transition-colors border border-gray-300 rounded-md cursor-pointer dark:hover:text-slate-800 hover:bg-gray-200 focus:outline-none focus:ring focus:border-blue-300"
                        v-if="link.url" :class="{ 'bg-gray-200 text-slate-800': link.active }">
                    {{ link.label }}
                    </Link>
                    <span v-else class="px-3 py-2 border border-gray-300 rounded-md">{{ link.label }}</span>
                </li>

                <li :class="{ 'disabled': $page.props.datas.links[$page.props.datas.links.length - 1].url === null }">
                    <Link :href="$page.props.datas.links[$page.props.datas.links.length - 1].url"
                        class="px-3 py-2 transition-colors border border-gray-300 rounded-md cursor-pointer hover:bg-gray-200 focus:outline-none focus:ring focus:border-blue-300"
                        v-if="$page.props.datas.links[$page.props.datas.links.length - 1].url" rel="next">
                    &raquo;
                    </Link>
                    <span v-else class="px-3 py-2 border border-gray-300 rounded-md">&raquo;</span>
                </li>
            </ul>
        </nav>
    </div>
</template>
