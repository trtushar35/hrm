<script setup>
import { ref, onMounted } from 'vue';
import BackendLayout from '@/Layouts/BackendLayout.vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AlertMessage from '@/Components/AlertMessage.vue';
import { displayResponse, displayWarning } from '@/responseMessage.js';

const props = defineProps(['user', 'id', 'roles', 'departments', 'designations']);

const form = useForm({
    first_name: props.user?.first_name ?? '',
    last_name: props.user?.last_name ?? '',
    email: props.user?.email ?? '',
    photo: '',
    photoPreview: props.user?.photo ?? '',
    phone: props.user?.phone ?? '',
    role_id: props.user?.role_id ?? '',
    department_id: props.user?.department_id ?? '',
    designation_id: props.user?.designation_id ?? '',
    salary: props.user?.salary ?? '',
    password: '',

    address: props.user?.address ?? '',
    _method: props.user?.id ? 'put' : 'post',
});

const handlePhotoChange = (event) => {
    const file = event.target.files[0];
    form.photo = file;

    // Display photo preview
    const reader = new FileReader();
    reader.onload = (e) => {
        form.photoPreview = e.target.result;
    };
    reader.readAsDataURL(file);
};

const submit = () => {
    const routeName = props.id ? route('backend.admin.update', props.id) : route('backend.admin.store');
    form.transform(data => ({
        ...data,
        remember: '',
        isDirty: false,
    })).post(routeName, {

        onSuccess: (response) => {
            if (!props.id)
                form.reset();
            displayResponse(response);
        },
        onError: (errorObject) => {

            displayWarning(errorObject);
        },
    });
};



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
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4">

                    <div class="col-span-1 md:col-span-2">
                        <InputLabel for="photo" value="Photo" />
                        <div v-if="form.photoPreview">
                            <img :src="form.photoPreview" alt="Photo Preview" class="max-w-xs mt-2" height="60"
                                width="60" />
                        </div>
                        <input id="photo" type="file" accept="image/*"
                            class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
                            @change="handlePhotoChange" />
                        <InputError class="mt-2" :message="form.errors.photo" />
                    </div>

                    <div class="col-span-1 md:col-span-1">
                        <InputLabel for="first_name" value="First Name" />
                        <input id="first_name"
                            class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
                            v-model="form.first_name" type="text" placeholder="First Name" />
                        <InputError class="mt-2" :message="form.errors.first_name" />
                    </div>

                    <div class="col-span-1 md:col-span-1">
                        <InputLabel for="last_name" value="Last Name" />
                        <input id="last_name"
                            class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
                            v-model="form.last_name" type="text" placeholder="Last Name" />
                        <InputError class="mt-2" :message="form.errors.last_name" />
                    </div>
                    <div class="col-span-1 md:col-span-1">
                        <InputLabel for="email" value="Email" />
                        <input id="email"
                            class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
                            v-model="form.email" type="email" placeholder="Email" />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="col-span-1 md:col-span-1">
                        <InputLabel for="phone" value="Phone" />
                        <input id="phone"
                            class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
                            v-model="form.phone" type="text" placeholder="Phone" />
                        <InputError class="mt-2" :message="form.errors.phone" />
                    </div>

                    <div class="col-span-1 md:col-span-1">
                        <InputLabel for="role_id" value="Role" />
                        <select id="role_id"
                            class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
                            v-model="form.role_id" placeholder="Select Role">
                            <option value="">--Select Role--</option>
                            <template v-for="role in roles">
                                <option :value="role.id">{{ role.name }}</option>
                            </template>
                        </select>
                        <InputError class="mt-2" :message="form.errors.role_id" />
                    </div>

                    <div class="col-span-1 md:col-span-1">
                        <InputLabel for="department_id" value="Department" />
                        <select id="department_id"
                            class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
                            v-model="form.department_id" placeholder="Select Department">
                            <option value="">--Select Department--</option>
                            <template v-for="data in departments">
                                <option :value="data.id">{{ data.name }}</option>
                            </template>
                        </select>
                        <InputError class="mt-2" :message="form.errors.department_id" />
                    </div>

                    <div class="col-span-1 md:col-span-1">
                        <InputLabel for="designation_id" value="Designation" />
                        <select id="designation_id"
                            class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
                            v-model="form.designation_id" placeholder="Select Designation">
                            <option value="">--Select Designation--</option>
                            <template v-for="data in designations">
                                <option :value="data.id">{{ data.name }}</option>
                            </template>
                        </select>
                        <InputError class="mt-2" :message="form.errors.designation_id" />
                    </div>

                    <div class="col-span-1 md:col-span-1">
                        <InputLabel for="salary" value="Salary" />
                        <input id="salary"
                            class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
                            v-model="form.salary" type="number" placeholder="Salary" />
                        <InputError class="mt-2" :message="form.errors.salary" />
                    </div>

                    <div class="col-span-1 md:col-span-1">
                        <InputLabel for="password" value="Password" />
                        <input id="password"
                            class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
                            v-model="form.password" type="password" placeholder="Password" />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="col-span-4 md:col-span-4">
                        <InputLabel for="address" value="Address" />
                        <textarea id="address"
                            class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
                            v-model="form.address" type="text" placeholder="address" />
                        <InputError class="mt-2" :message="form.errors.address" />
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
    </BackendLayout>
</template>
