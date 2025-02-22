<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import BackendLayout from '@/Layouts/BackendLayout.vue';
import BarChart from '@/Components/Chart/BarChart.vue';
import PieChart from '@/Components/Chart/PieChart.vue';
import DoughnutChart from '@/Components/Chart/DoughnutChart.vue';
import LineChart from '@/Components/Chart/LineChart.vue';
import PolarAreaChart from '@/Components/Chart/PolarAreaChart.vue';
import RadarChart from '@/Components/Chart/RadarChart.vue';

const props = defineProps(['dashboardData']);

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <BackendLayout>
        <section class="w-full mt-4 transition duration-1000 ease-in-out">
            <div class="grid gap-4 xs:grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">



                <div class="w-full h-20 pl-1 bg-yellow-400 rounded-lg shadow-md">
                    <div class="flex justify-between w-full h-full px-4 py-2 bg-white rounded-lg">
                        <div class="my-auto">
                            <p class="text-sm font-bold sm:text-md">Active Users</p>
                            <p class="text-lg">{{ dashboardData.activeUsers }} </p>
                        </div>
                        <div class="my-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="w-full h-20 pl-1 bg-yellow-400 rounded-lg shadow-md">
                    <div class="flex justify-between w-full h-full px-4 py-2 bg-white rounded-lg">
                        <div class="my-auto">
                            <p class="text-sm font-bold sm:text-md">Inactive Users</p>
                            <p class="text-lg">{{ dashboardData.inActiveUsers }} </p>
                        </div>
                        <div class="my-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="w-full h-20 pl-1 bg-yellow-400 rounded-lg shadow-md">
                    <div class="flex justify-between w-full h-full px-4 py-2 bg-white rounded-lg">
                        <div class="my-auto">
                            <p class="text-sm font-bold sm:text-md">Active Users</p>
                            <p class="text-lg">{{ dashboardData.activeUsers }} </p>
                        </div>
                        <div class="my-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="w-full h-20 pl-1 bg-yellow-400 rounded-lg shadow-md">
                    <div class="flex justify-between w-full h-full px-4 py-2 bg-white rounded-lg">
                        <div class="my-auto">
                            <p class="text-sm font-bold sm:text-md">Inactive Users</p>
                            <p class="text-lg">{{ dashboardData.inActiveUsers }} </p>
                        </div>
                        <div class="my-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>



            </div>
        </section>

        <section class="grid gap-4 mt-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="flex flex-col bg-white rounded-lg shadow md:col-span-2 md:row-span-2">
                <div class="px-6 py-5 font-semibold border-b border-gray-100">The Attendance and left Employee per month
                </div>
                <div class="flex-grow p-4">
                    <div
                        class="flex items-center justify-center h-full px-4 py-16 text-3xl font-semibold text-gray-400 bg-gray-100 border-2 border-gray-200 border-dashed rounded-md">
                        <BarChart />
                    </div>
                </div>
            </div>

            <div class="flex flex-col bg-white rounded-lg shadow md:col-span-2 md:row-span-2">
                <div class="px-6 py-5 font-semibold border-b border-gray-100">The Attendance and left Employee per month
                </div>
                <div class="flex-grow p-4">
                    <div
                        class="flex items-center justify-center h-full px-4 py-16 text-3xl font-semibold text-gray-400 bg-gray-100 border-2 border-gray-200 border-dashed rounded-md">
                        <PieChart />
                    </div>
                </div>
            </div>

        </section>

        <section class="grid gap-4 mt-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="flex flex-col bg-white rounded-lg shadow md:col-span-2 md:row-span-2">
                <div class="px-6 py-5 font-semibold border-b border-gray-100">The Attendance and left Employee per month
                </div>
                <div class="flex-grow p-4">
                    <div
                        class="flex items-center justify-center h-full px-4 py-16 text-3xl font-semibold text-gray-400 bg-gray-100 border-2 border-gray-200 border-dashed rounded-md">
                        <DoughnutChart />
                    </div>
                </div>
            </div>

            <div class="flex flex-col bg-white rounded-lg shadow md:col-span-2 md:row-span-2">
                <div class="px-6 py-5 font-semibold border-b border-gray-100">The Attendance and left Employee per month
                </div>
                <div class="flex-grow p-4">
                    <div
                        class="flex items-center justify-center h-full px-4 py-16 text-3xl font-semibold text-gray-400 bg-gray-100 border-2 border-gray-200 border-dashed rounded-md">
                        <LineChart />
                    </div>
                </div>
            </div>

        </section>

        <section class="grid gap-4 mt-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="flex flex-col bg-white rounded-lg shadow md:col-span-2 md:row-span-2">
                <div class="px-6 py-5 font-semibold border-b border-gray-100">The Attendance and left Employee per month
                </div>
                <div class="flex-grow p-4">
                    <div
                        class="flex items-center justify-center h-full px-4 py-16 text-3xl font-semibold text-gray-400 bg-gray-100 border-2 border-gray-200 border-dashed rounded-md">
                        <PolarAreaChart />
                    </div>
                </div>
            </div>

            <div class="flex flex-col bg-white rounded-lg shadow md:col-span-2 md:row-span-2">
                <div class="px-6 py-5 font-semibold border-b border-gray-100">The Attendance and left Employee per month
                </div>
                <div class="flex-grow p-4">
                    <div
                        class="flex items-center justify-center h-full px-4 py-16 text-3xl font-semibold text-gray-400 bg-gray-100 border-2 border-gray-200 border-dashed rounded-md">
                        <RadarChart />
                    </div>
                </div>
            </div>

        </section>

    </BackendLayout>
</template>

