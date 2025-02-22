<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from "vue";
import BackendLayout from '@/Layouts/BackendLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

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
    <BackendLayout title="Dashboard d">

        

        <div class="w-full bg-white dark:bg-slate-900 p-8 mt-3 transition duration-1000 ease-in-out">
            <div class=" grid xs:grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <!--  Monthly card start  -->
                <div class="pl-1 w-full h-20 bg-green-400 rounded-lg shadow-md">
                    <div class="flex w-full h-full py-2 px-4 bg-gray-50 rounded-lg justify-between">
                        <div class="my-auto">
                            <p class="font-bold text-sm sm:text-md">EARNINGS (MONTHLY)</p>
                            <p class="text-lg">$40,000</p>
                        </div>
                        <div class="my-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
                <!--  Monthly card end  -->
                <!--  Annual card start -->
                <div class="pl-1 w-full h-20 bg-blue-500 rounded-lg shadow-md">
                    <div class="flex w-full h-full py-2 px-4 bg-gray-50 rounded-lg justify-between">
                        <div class="my-auto">
                            <p class="font-bold text-sm sm:text-md">EARNINGS (ANNUAL)</p>
                            <p class="text-lg">$215,000</p>
                        </div>
                        <div class="my-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
                <!--  Annual card end  -->
                <!--  Tasks card start  -->
                <div class="pl-1 w-full h-20 bg-purple-500 rounded-lg shadow-md">
                    <div class="flex w-full h-full py-2 px-4 bg-gray-100 rounded-lg justify-between">
                        <div class="my-auto">
                            <p class="font-bold text-sm sm:text-md">TASKS</p>
                            <p class="text-lg">50%</p>
                        </div>
                        <div class="my-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
                <!--  Tasks card end  -->
                <!--  Pending requests card start  -->
                <div class="pl-1 w-full h-20 bg-yellow-400 rounded-lg shadow-md">
                    <div class="flex w-full h-full py-2 px-4 bg-gray-100 rounded-lg justify-between">
                        <div class="my-auto">
                            <p class="font-bold text-sm sm:text-md">PENDING REQUESTS</p>
                            <p class="text-lg">18</p>
                        </div>
                        <div class="my-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
                <!--  Pending requests card end  -->
            </div>
        </div>

        <div class="w-full bg-white dark:bg-slate-900 p-8 mt-3 transition duration-1000 ease-in-out">
            <div class=" grid grid-cols-3 gap-4">
                <div class="w-full">
                    <div class="rounded-lg shadow-sm mb-4">
                        <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                            <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                <h4 class="text-sm uppercase text-gray-500 leading-tight">Users</h4>
                                <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">3,682</h3>
                                <p class="text-xs text-green-500 leading-tight">▲ 57.1%</p>
                            </div>
                            <div class="absolute bottom-0 inset-x-0">
                                <canvas id="chart1" height="70"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full">
                    <div class="rounded-lg shadow-sm mb-4">
                        <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                            <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                <h4 class="text-sm uppercase text-gray-500 leading-tight">Subscribers</h4>
                                <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">11,427</h3>
                                <p class="text-xs text-red-500 leading-tight">▼ 42.8%</p>
                            </div>
                            <div class="absolute bottom-0 inset-x-0">
                                <canvas id="chart2" height="70"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full">
                    <div class="rounded-lg shadow-sm mb-4">
                        <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                            <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                <h4 class="text-sm uppercase text-gray-500 leading-tight">Comments</h4>
                                <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">8,028</h3>
                                <p class="text-xs text-green-500 leading-tight">▲ 8.2%</p>
                            </div>
                            <div class="absolute bottom-0 inset-x-0">
                                <canvas id="chart3" height="70"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full bg-white dark:bg-slate-900 p-8 mt-3 transition duration-1000 ease-in-out">
            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    <div>
                        <InputLabel for="name" value="Name" />
                        <TextInput id="name" v-model="form.name" type="text" class="block w-full"
                            placeholder="Enter Your Name" required autofocus autocomplete="name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div>
                        <InputLabel for="last_name" value="Last Name" />
                        <TextInput id="last_name" v-model="form.name" type="text" class="block w-full" required autofocus
                            autocomplete="name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div>
                        <InputLabel for="last_name" value="Last Name" />
                        <TextInput id="last_name" v-model="form.name" type="text" class="block w-full" required autofocus
                            autocomplete="name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div>
                        <InputLabel for="name" value="Name" />
                        <TextInput id="name" v-model="form.name" type="text" class="block w-full"
                            placeholder="Enter Your Name" required autofocus autocomplete="name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div>
                        <InputLabel for="last_name" value="Last Name" />
                        <TextInput id="last_name" v-model="form.name" type="text" class="block w-full" required autofocus
                            autocomplete="name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div>
                        <InputLabel for="last_name" value="Last Name" />
                        <TextInput id="last_name" v-model="form.name" type="text" class="block w-full" required autofocus
                            autocomplete="name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div>
                        <InputLabel for="name" value="Name" />
                        <TextInput id="name" v-model="form.name" type="text" class="block w-full"
                            placeholder="Enter Your Name" required autofocus autocomplete="name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div>
                        <InputLabel for="last_name" value="Last Name" />
                        <TextInput id="last_name" v-model="form.name" type="text" class="block w-full" required autofocus
                            autocomplete="name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div>
                        <InputLabel for="last_name" value="Last Name" />
                        <TextInput id="last_name" v-model="form.name" type="text" class="block w-full" required autofocus
                            autocomplete="name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Submit
                    </PrimaryButton>
                </div>
            </form>
        </div>


        <div class="w-full bg-white dark:bg-slate-900 p-8 mt-3 transition duration-1000 ease-in-out">
            <div class="container mx-auto px-4 sm:px-8">
                <div class="py-8">
                    <div>
                        <h2 class="text-2xl font-semibold leading-tight">Invoices</h2>
                    </div>
                    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                        <div class="inline-block min-w-full shadow-md rounded-lg overflow-hidden">
                            <table class="min-w-full leading-normal">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Client / Invoice
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Amount
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Issued / Due
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <div class="flex">
                                                <div class="flex-shrink-0 w-10 h-10">
                                                    <img class="w-full h-full rounded-full"
                                                        src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80"
                                                        alt="" />
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        Molly Sanders
                                                    </p>
                                                    <p class="text-gray-600 whitespace-no-wrap">000004</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">$20,000</p>
                                            <p class="text-gray-600 whitespace-no-wrap">USD</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">Sept 28, 2019</p>
                                            <p class="text-gray-600 whitespace-no-wrap">Due in 3 days</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <span
                                                class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                                <span aria-hidden
                                                    class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                                <span class="relative">Paid</span>
                                            </span>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right">
                                            <button type="button" class="inline-block text-gray-500 hover:text-gray-700">
                                                <svg class="inline-block h-6 w-6 fill-current" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 6a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm-2 6a2 2 0 104 0 2 2 0 00-4 0z" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <div class="flex">
                                                <div class="flex-shrink-0 w-10 h-10">
                                                    <img class="w-full h-full rounded-full"
                                                        src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80"
                                                        alt="" />
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        Michael Roberts
                                                    </p>
                                                    <p class="text-gray-600 whitespace-no-wrap">000003</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">$214,000</p>
                                            <p class="text-gray-600 whitespace-no-wrap">USD</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">Sept 25, 2019</p>
                                            <p class="text-gray-600 whitespace-no-wrap">Due in 6 days</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <span
                                                class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                                <span aria-hidden
                                                    class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                                <span class="relative">Paid</span>
                                            </span>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right">
                                            <button type="button" class="inline-block text-gray-500 hover:text-gray-700">
                                                <svg class="inline-block h-6 w-6 fill-current" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 6a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm-2 6a2 2 0 104 0 2 2 0 00-4 0z" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <div class="flex">
                                                <div class="flex-shrink-0 w-10 h-10">
                                                    <img class="w-full h-full rounded-full"
                                                        src="https://images.unsplash.com/photo-1540845511934-7721dd7adec3?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80"
                                                        alt="" />
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        Devin Childs
                                                    </p>
                                                    <p class="text-gray-600 whitespace-no-wrap">000002</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">$20,000</p>
                                            <p class="text-gray-600 whitespace-no-wrap">USD</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">Sept 14, 2019</p>
                                            <p class="text-gray-600 whitespace-no-wrap">Due in 2 weeks</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <span
                                                class="relative inline-block px-3 py-1 font-semibold text-orange-900 leading-tight">
                                                <span aria-hidden
                                                    class="absolute inset-0 bg-orange-200 opacity-50 rounded-full"></span>
                                                <span class="relative">Pending</span>
                                            </span>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right">
                                            <button type="button" class="inline-block text-gray-500 hover:text-gray-700">
                                                <svg class="inline-block h-6 w-6 fill-current" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 6a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm-2 6a2 2 0 104 0 2 2 0 00-4 0z" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-5 py-5 bg-white text-sm">
                                            <div class="flex">
                                                <div class="flex-shrink-0 w-10 h-10">
                                                    <img class="w-full h-full rounded-full"
                                                        src="https://images.unsplash.com/photo-1522609925277-66fea332c575?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&h=160&w=160&q=80"
                                                        alt="" />
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        Frederick Nicholas
                                                    </p>
                                                    <p class="text-gray-600 whitespace-no-wrap">000001</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">$12,000</p>
                                            <p class="text-gray-600 whitespace-no-wrap">USD</p>
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">Sept 6, 2019</p>
                                            <p class="text-gray-600 whitespace-no-wrap">
                                                Due 3 weeks ago
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm">
                                            <span
                                                class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                                <span aria-hidden
                                                    class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                                <span class="relative">Overdue</span>
                                            </span>
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm text-right">
                                            <button type="button" class="inline-block text-gray-500 hover:text-gray-700">
                                                <svg class="inline-block h-6 w-6 fill-current" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 6a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm-2 6a2 2 0 104 0 2 2 0 00-4 0z" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full bg-white dark:bg-slate-900 p-8 mt-3 transition duration-1000 ease-in-out">

            <h1 class="font-bold text-xl"> Kullanıcılar ve iş sayıları</h1>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Surname</th>
                            <th scope="col" class="px-6 py-3">Work Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hover:bg-gray-100 bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                1
                            </th>
                            <td class="px-6 py-4">Hakan</td>
                            <td class="px-6 py-4">Akgul</td>
                            <td class="px-6 py-4">22</td>
                        </tr>

                        <tr class="hover:bg-gray-100 bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                1
                            </th>
                            <td class="px-6 py-4">John</td>
                            <td class="px-6 py-4">Smith</td>
                            <td class="px-6 py-4">4</td>
                        </tr>

                        <tr class="hover:bg-gray-100 bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                1
                            </th>
                            <td class="px-6 py-4">Hakan</td>
                            <td class="px-6 py-4">Akgül</td>
                            <td class="px-6 py-4">22</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="w-full bg-white dark:bg-slate-900 p-8 mt-3 transition duration-1000 ease-in-out">
            <div class="container mx-auto px-4 sm:px-8">
                <div class="py-8">
                    <div>
                        <h2 class="text-2xl font-semibold leading-tight">Users</h2>
                    </div>
                    <div class="my-2 flex sm:flex-row flex-col">
                        <div class="flex flex-row mb-1 sm:mb-0">
                            <div class="relative">
                                <select
                                    class="appearance-none h-full rounded-l border block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option>5</option>
                                    <option>10</option>
                                    <option>20</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="relative">
                                <select
                                    class="appearance-none h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                                    <option>All</option>
                                    <option>Active</option>
                                    <option>Inactive</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="block relative">
                            <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                                <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                                    <path
                                        d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                                    </path>
                                </svg>
                            </span>
                            <input placeholder="Search"
                                class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
                        </div>
                    </div>
                    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                            <table class="min-w-full leading-normal">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            User
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Rol
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Created at
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-10 h-10">
                                                    <img class="w-full h-full rounded-full"
                                                        src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80"
                                                        alt="" />
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        Vera Carpenter
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">Admin</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                Jan 21, 2020
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <span
                                                class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                                <span aria-hidden
                                                    class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                                <span class="relative">Activo</span>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-10 h-10">
                                                    <img class="w-full h-full rounded-full"
                                                        src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80"
                                                        alt="" />
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        Blake Bowman
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">Editor</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                Jan 01, 2020
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <span
                                                class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                                <span aria-hidden
                                                    class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                                <span class="relative">Activo</span>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-10 h-10">
                                                    <img class="w-full h-full rounded-full"
                                                        src="https://images.unsplash.com/photo-1540845511934-7721dd7adec3?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80"
                                                        alt="" />
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        Dana Moore
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">Editor</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                Jan 10, 2020
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <span
                                                class="relative inline-block px-3 py-1 font-semibold text-orange-900 leading-tight">
                                                <span aria-hidden
                                                    class="absolute inset-0 bg-orange-200 opacity-50 rounded-full"></span>
                                                <span class="relative">Suspended</span>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-5 py-5 bg-white text-sm">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-10 h-10">
                                                    <img class="w-full h-full rounded-full"
                                                        src="https://images.unsplash.com/photo-1522609925277-66fea332c575?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&h=160&w=160&q=80"
                                                        alt="" />
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        Alonzo Cox
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">Admin</p>
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">Jan 18, 2020</p>
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm">
                                            <span
                                                class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                                <span aria-hidden
                                                    class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                                <span class="relative">Inactive</span>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div
                                class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between          ">
                                <span class="text-xs xs:text-sm text-gray-900">
                                    Showing 1 to 4 of 50 Entries
                                </span>
                                <div class="inline-flex mt-2 xs:mt-0">
                                    <button
                                        class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-l">
                                        Prev
                                    </button>
                                    <button
                                        class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-r">
                                        Next
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="w-full bg-slate-400 p-8 mt-3">
            <div class="flex flex-col">
                <div class="my-2 overflow-x-auto sm:-max-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 m-4 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Title
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Role
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full"
                                                        src="https://ui-avatars.com/api/?name=Sebas+Luna&background=random"
                                                        alt="Some">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        Sebastian Luna
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        email@email.com
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Co-founder</div>
                                            <div class="text-sm text-gray-500">Developer</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            Admin
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full"
                                                        src="https://ui-avatars.com/api/?name=Vilfer+Alvarez&background=random"
                                                        alt="Some">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        Vilfer Alvarez
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        email@email.com
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Co-founder</div>
                                            <div class="text-sm text-gray-500">Developer</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            Admin
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </diV>
            </div>
        </div>


        <div class="w-full bg-slate-400 p-8 mt-3">
            <table class="border-collapse border border-slate-500 w-full">
                <thead>
                    <tr class=" bg-gray-200">
                        <th class="border border-slate-600 ...">State</th>
                        <th class="border border-slate-600 ...">City</th>
                        <th class="border border-slate-600 ...">State</th>
                        <th class="border border-slate-600 ...">City</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-slate-700 px-2">Indiana</td>
                        <td class="border border-slate-700 px-2">Indianapolis</td>
                        <td class="border border-slate-700 px-2">Indiana</td>
                        <td class="border border-slate-700 px-2">Indianapolis</td>
                    </tr>
                    <tr>
                        <td class="border border-slate-700 px-2">Ohio</td>
                        <td class="border border-slate-700 px-2">Columbus</td>
                        <td class="border border-slate-700 px-2">Ohio</td>
                        <td class="border border-slate-700 px-2">Columbus</td>
                    </tr>
                    <tr>
                        <td class="border border-slate-700 px-2">Michigan</td>
                        <td class="border border-slate-700 px-2">Detroit</td>
                        <td class="border border-slate-700 px-2">Michigan</td>
                        <td class="border border-slate-700 px-2">Detroit</td>
                    </tr>
                    <tr>
                        <td class="border border-slate-700 px-2">Michigan</td>
                        <td class="border border-slate-700 px-2">Detroit</td>
                        <td class="border border-slate-700 px-2">Michigan</td>
                        <td class="border border-slate-700 px-2">Detroit</td>
                    </tr>
                    <tr>
                        <td class="border border-slate-700 px-2">Michigan</td>
                        <td class="border border-slate-700 px-2">Detroit</td>
                        <td class="border border-slate-700 px-2">Michigan</td>
                        <td class="border border-slate-700 px-2">Detroit</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="w-full bg-slate-400 p-8 mt-3">
            <!-- Content -->
            <div class="w-full bg-grey-lightest" style="padding-top: 4rem;">
                <div class="container mx-auto py-8">
                    <div class="w-5/6 lg:w-1/2 mx-auto bg-white rounded shadow">
                        <div class="py-4 px-8 text-black text-xl border-b border-grey-lighter">Register for a free account
                        </div>
                        <div class="py-4 px-8">
                            <div class="flex mb-4">
                                <div class="w-1/2 mr-1">
                                    <label class="block text-grey-darker text-sm font-bold mb-2" for="first_name">First
                                        Name</label>
                                    <input class="appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                                        id="first_name" type="text" placeholder="Your first name">
                                </div>
                                <div class="w-1/2 ml-1">
                                    <label class="block text-grey-darker text-sm font-bold mb-2" for="last_name">Last
                                        Name</label>
                                    <input class="appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                                        id="last_name" type="text" placeholder="Your last name">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-grey-darker text-sm font-bold mb-2" for="email">Email
                                    Address</label>
                                <input class="appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="email"
                                    type="email" placeholder="Your email address">
                            </div>
                            <div class="mb-4">
                                <label class="block text-grey-darker text-sm font-bold mb-2" for="password">Password</label>
                                <input class="appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                                    id="password" type="password" placeholder="Your secure password">
                                <p class="text-grey text-xs mt-1">At least 6 characters</p>
                            </div>
                            <div class="flex items-center justify-between mt-8">
                                <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-full"
                                    type="submit">
                                    Sign Up
                                </button>
                            </div>
                        </div>
                    </div>
                    <p class="text-center my-4">
                        <a href="#" class="text-grey-dark text-sm no-underline hover:text-grey-darker">I already have an
                            account</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="w-full bg-slate-400 p-8 mt-3">
            <div class="min-w-screen min-h-screen bg-gray-200 flex items-center justify-center px-5 py-5">
                <div class="w-full max-w-3xl">
                    <div class="-mx-2 md:flex">
                        <div class="w-full md:w-1/3 px-2">
                            <div class="rounded-lg shadow-sm mb-4">
                                <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                    <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                        <h4 class="text-sm uppercase text-gray-500 leading-tight">Users</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">3,682</h3>
                                        <p class="text-xs text-green-500 leading-tight">▲ 57.1%</p>
                                    </div>
                                    <div class="absolute bottom-0 inset-x-0">
                                        <canvas id="chart1" height="70"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 px-2">
                            <div class="rounded-lg shadow-sm mb-4">
                                <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                    <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                        <h4 class="text-sm uppercase text-gray-500 leading-tight">Subscribers</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">11,427</h3>
                                        <p class="text-xs text-red-500 leading-tight">▼ 42.8%</p>
                                    </div>
                                    <div class="absolute bottom-0 inset-x-0">
                                        <canvas id="chart2" height="70"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 px-2">
                            <div class="rounded-lg shadow-sm mb-4">
                                <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                    <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                        <h4 class="text-sm uppercase text-gray-500 leading-tight">Comments</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">8,028</h3>
                                        <p class="text-xs text-green-500 leading-tight">▲ 8.2%</p>
                                    </div>
                                    <div class="absolute bottom-0 inset-x-0">
                                        <canvas id="chart3" height="70"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>


        <div class=" grid grid-cols-1 sm:grid-cols-2 gap-3 py-2">
            <div
                class="bg-slate-300 hover:bg-slate-400 dark:bg-slate-900 dark:hover:bg-slate-800 transition duration-1000 ease-in-out h-64 w-full rounded-sm">
                <h1>Card</h1>
            </div>
            <div
                class="bg-slate-300 hover:bg-slate-400 dark:bg-slate-900 dark:hover:bg-slate-800 transition duration-1000 ease-in-out h-64 w-full rounded-sm">
                <h1>Card</h1>
            </div>
        </div>
        <div class=" grid grid-cols-2 sm:grid-cols-3 gap-3 py-2">
            <div
                class="bg-slate-300 hover:bg-slate-400 dark:bg-slate-900 dark:hover:bg-slate-800 transition duration-1000 ease-in-out h-64 w-full rounded-sm">
                <h1>Card</h1>
            </div>
            <div
                class="bg-slate-300 hover:bg-slate-400 dark:bg-slate-900 dark:hover:bg-slate-800 transition duration-1000 ease-in-out h-64 w-full rounded-sm">
                <h1>Card</h1>
            </div>
            <div
                class="bg-slate-300 hover:bg-slate-400 dark:bg-slate-900 dark:hover:bg-slate-800 transition duration-1000 ease-in-out h-64 w-full rounded-sm">
                <h1>Card</h1>
            </div>
        </div>
        <div class=" grid grid-cols-2 sm:grid-cols-4 gap-3 py-2">
            <div
                class="bg-slate-300 hover:bg-slate-400 dark:bg-slate-900 dark:hover:bg-slate-800 transition duration-1000 ease-in-out h-64 w-full rounded-sm">
                <h1>Card</h1>
            </div>
            <div
                class="bg-slate-300 hover:bg-slate-400 dark:bg-slate-900 dark:hover:bg-slate-800 transition duration-1000 ease-in-out h-64 w-full rounded-sm">
                <h1>Card</h1>
            </div>
            <div
                class="bg-slate-300 hover:bg-slate-400 dark:bg-slate-900 dark:hover:bg-slate-800 transition duration-1000 ease-in-out h-64 w-full rounded-sm">
                <h1>Card</h1>
            </div>
            <div
                class="bg-slate-300 hover:bg-slate-400 dark:bg-slate-900 dark:hover:bg-slate-800 transition duration-1000 ease-in-out h-64 w-full rounded-sm">
                <h1>Card</h1>
            </div>
        </div>
        <div class=" grid grid-cols-2 sm:grid-cols-3 gap-3 py-2">
            <div
                class="bg-slate-300 hover:bg-slate-400 dark:bg-slate-900 dark:hover:bg-slate-800 transition duration-1000 ease-in-out h-64 w-full rounded-sm">
                <h1>Card</h1>
            </div>
            <div
                class="bg-slate-300 hover:bg-slate-400 dark:bg-slate-900 dark:hover:bg-slate-800 transition duration-1000 ease-in-out h-64 w-full rounded-sm">
                <h1>Card</h1>
            </div>
            <div
                class="bg-slate-300 hover:bg-slate-400 dark:bg-slate-900 dark:hover:bg-slate-800 transition duration-1000 ease-in-out h-64 w-full rounded-sm">
                <h1>Card</h1>
            </div>
        </div>
    </BackendLayout>
</template>
