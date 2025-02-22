
<script setup>
    import { ref } from "vue";
    import BackendLayout from '@/Layouts/BackendLayout.vue';
    import BaseTable from '@/Components/BaseTable.vue';
    import Pagination from '@/Components/Pagination.vue';
    import { router } from '@inertiajs/vue3';

    let props = defineProps({
        filters: Object,
    });

    const filters = ref({

        numOfData: props.filters?.numOfData ?? 10,
    });

    const applyFilter = () => {
        router.get(route('backend.department.index'), filters.value, { preserveState: true });
    };

    </script>

    <template>
        <BackendLayout>

            <div
                class="w-full p-4 mt-3 duration-1000 ease-in-out bg-white rounded shadow-md shadow-gray-800/50 dark:bg-slate-900">



                <div
                    class="flex justify-between w-full p-4 space-x-2 text-gray-700 rounded shadow-md bg-slate-600 shadow-gray-800/50 dark:bg-gray-700 dark:text-gray-200">

                    <div class="grid w-full grid-cols-1 gap-2 md:grid-cols-5">

                        <div class="flex space-x-2">
                            <div class="w-full">
                                <input id="name" v-model="filters.name"
                                    class="block w-full p-2 text-sm bg-gray-300 rounded shadow-sm border-slate-100 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
                                    type="text" placeholder="Title" @input="applyFilter" />
                            </div>

                        </div>
                    </div>

                    <div class="hidden min-w-24 md:block">
                        <select v-model="filters.numOfData" @change="applyFilter"
                                class="w-full p-2 text-sm bg-gray-300 rounded shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600">
                            <option value="10">show 10</option>
                            <option value="20">show 20</option>
                            <option value="30">show 30</option>
                            <option value="40">show 40</option>
                            <option value="100">show 100</option>
                            <option value="150">show 150</option>
                            <option value="500">show 500</option>
                        </select>
                    </div>
                </div>

                <div class="w-full my-3 overflow-x-auto">
                    <BaseTable />
                </div>
                <Pagination />
            </div>
        </BackendLayout>
    </template>

