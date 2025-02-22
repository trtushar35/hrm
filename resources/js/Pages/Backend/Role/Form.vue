<script setup>
import { ref, onMounted, computed } from 'vue';
import BackendLayout from '@/Layouts/BackendLayout.vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AlertMessage from '@/Components/AlertMessage.vue';
import { displayResponse, displayWarning } from '@/responseMessage.js';

const props = defineProps(['role', 'permissions', 'id']);

const form = useForm({
    name: props.role?.name ?? '',
    guard_name: props.role?.guard_name ?? 'admin',
    permission_ids: props.role?.permission_ids ?? [],
    _method: props.role?.id ? 'put' : 'post',
});


const submit = () => {
    const routeName = props.id ? route('backend.role.update', props.id) : route('backend.role.store');
    form.transform(data => ({
        ...data,
        remember: '',
        isDirty: false,
    })).post(routeName, {

        onSuccess: (response) => {
            if (!props.id)
                form.reset();
            displayResponse(response)
        },
        onError: (errorObject) => {

            displayWarning(errorObject);
        },
    });
};

const checkedPermissions = computed({
    get: () => form.permission_ids,
    set: (newValue) => form.permission_ids = newValue,
});


</script>

<template>
    <BackendLayout>
        <div
            class="w-full mt-3 transition duration-1000 ease-in-out transform bg-white border border-gray-700 rounded-md shadow-lg shadow-gray-800/50 dark:bg-slate-900">

            <div
                class="flex items-center justify-between w-full text-gray-700 bg-gray-100 rounded-md shadow-md dark:bg-gray-800 dark:text-gray-200 shadow-gray-800/50">
                <div>
                    <h1 class="p-4 text-xl font-bold dark:text-white">{{ $page.props.pageTitle }}</h1>
                </div>
                <div class="p-4 py-2">
                </div>
            </div>

            <form @submit.prevent="submit" class="p-4">
                <AlertMessage />
                <!-- <pre>{{ form }}</pre> -->
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4">

                    <div class="col-span-1 md:col-span-2">
                        <InputLabel for="name" value="Role Name" />
                        <input id="name"
                            class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
                            v-model="form.name" type="text" placeholder="Role Name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <InputLabel for="guard_name" value="Guard Name" />
                        <input id="guard_name"
                            class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
                            v-model="form.guard_name" type="text" readonly placeholder="Guard Name" />
                        <InputError class="mt-2" :message="form.errors.bn_name" />
                    </div>

                </div>

                <div class="w-full mt-4 ">
                    <!-- <h1 class="font-bold text-dark">Permissions</h1> -->
                    <InputLabel for="Permissions" value="Permissions" />
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4">
                        <template v-for="permissionInfo in permissions">
                            <div class="font-bold">
                                <ul class="ml-4 ">
                                    <li
                                        :class="form.permission_ids.includes(permissionInfo.id) ? 'text-green-500' : 'text-blue-600'">
                                        <input v-model="checkedPermissions" :value="permissionInfo.id" type="checkbox"
                                            class="cursor-pointer" :id="'permission_' + permissionInfo.id">
                                        <label :for="'permission_' + permissionInfo.id" class="ml-2 cursor-pointer">{{
                                            permissionInfo.name }}</label>
                                        <ul v-if="permissionInfo.child" class="ml-4">

                                            <template v-for="childInfo in permissionInfo.child">
                                                <li class="ml-4 "
                                                    :class="form.permission_ids.includes(childInfo.id) ? 'text-green-500' : 'text-purple-800'">
                                                    <input v-model="checkedPermissions" :value="childInfo.id"
                                                        type="checkbox" class="cursor-pointer"
                                                        :id="'permission_' + childInfo.id">
                                                    <label :for="'permission_' + childInfo.id"
                                                        class="ml-2 cursor-pointer">{{ childInfo.name }}</label>

                                                    <ul v-if="childInfo.child" class="grid ml-4 gird">
                                                        <template v-for="childChildInfo in childInfo.child">
                                                            <li class="ml-4 "
                                                                :class="form.permission_ids.includes(childChildInfo.id) ? 'text-green-500' : 'text-gray-500'">
                                                                <input v-model="checkedPermissions"
                                                                    :value="childChildInfo.id" type="checkbox"
                                                                    class="cursor-pointer"
                                                                    :id="'permission_' + childChildInfo.id">
                                                                <label :for="'permission_' + childChildInfo.id"
                                                                    class="ml-2 cursor-pointer">{{ childChildInfo.name
                                                                    }}</label>
                                                            </li>
                                                        </template>
                                                    </ul>
                                                </li>
                                            </template>
                                        </ul>
                                    </li>

                                </ul>

                            </div>
                        </template>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton type="submit" class="ms-4" :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing">
                        {{ ((props.id ?? false) ? 'Update' : 'Create') }}
                    </PrimaryButton>
                </div>
            </form>

        </div>
</BackendLayout></template>
