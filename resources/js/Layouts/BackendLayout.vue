<script setup>
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Layouts/Partials/Sidebar.vue';
import Navbar from '@/Layouts/Partials/Navbar.vue';
import Breadcrumb from '@/Layouts/Partials/Breadcrumb.vue'; 


</script>

<template>
    <div>

        <Head :title="$page.props.pageTitle" />


        <div class="w-full bg-slate-300 dark:bg-slate-950">
            <!-- nav bar  -->
            <Navbar />

            <div class="flex w-full">
                <!-- side bar  -->
                <Sidebar />

                <!-- main content  -->
                <div class="w-full h-[calc(100vh-48px)] mt-12 overflow-y-auto p-3">
                    <!-- Page Breadcrumb -->

                    <Breadcrumb :breadcrumbs="$page.props.breadcrumbs"/>
                    <!-- Page Content -->
                    <main>
                        <slot />
                    </main>
                </div>
            </div>

        </div>

    </div>
</template>

<style>
/* width */
::-webkit-scrollbar {
    width: 3px;
    height: 5px;
}

/* Track */
::-webkit-scrollbar-track {
    box-shadow: inset 0 0 5px grey;
    border-radius: 10px;
}

/* Handle */
::-webkit-scrollbar-thumb {
    background: rgb(17, 0, 62);
    border-radius: 10px;
}


body {
    background-color: #f8f3f2 !important;
}
</style>
