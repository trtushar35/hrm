<script setup>
import { ref, onMounted, computed } from "vue";
import BackendLayout from "@/Layouts/BackendLayout.vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AlertMessage from "@/Components/AlertMessage.vue";
import { displayResponse, displayWarning } from "@/responseMessage.js";

const props = defineProps(['fillableAttributes']);

const form = useForm({
    modelName: "",

    fields: [
        {
            field_name: "",
            data_type: "",
            default_value: "",
            is_nullable: "",
            is_fillable: "",
            is_relation: "",
            is_hidden: "",
            enum_values: [],
            relation_table: '',
        },
    ],

    formField: [],
    relationField: [],

    _method: "post",
});

// Function to submit the form
const submit = () => {
    const routeName = route("backend.moduleMaker");
    form
        .transform((data) => ({
            ...data,
            remember: "",
            isDirty: false,
        }))
        .post(routeName, {
            onSuccess: (response) => {
                // form.reset();
                displayResponse(response);
            },
            onError: (errorObject) => {
                displayWarning(errorObject);
            },
        });
};

// Function to add more fields
const addMoreField = () => {
    form.fields.push({
        field_name: "",
        data_type: "",
        data_length: "",
        default_value: "",
        is_nullable: "",
        is_relation: "",
        is_fillable: "",
        is_hidden: "",
        enum_values: [],
        relation_table: '',
    });
};

const onDataTypeChange = (index) => {
    const fieldType = form.fields[index].data_type;
    if (fieldType != "Enum")
        form.fields[index].enum_values = [];
    switch (fieldType) {
        case "Enum":
            form.fields[index].data_length = 255;
            form.fields[index].enum_values.push({ value: "" });
            break;
        case "String":
            form.fields[index].data_length = 255;
            break;
        case "Integer":
            form.fields[index].data_length = 11;
            break;
        case "TinyInteger":
            form.fields[index].data_length = 4;
            break;
        case "BigInteger":
            form.fields[index].data_length = 20;
            break;
        case "Decimal":
            form.fields[index].data_length = '11,2';
            break;
        case "Boolean":
            form.fields[index].data_length = 1;
            break;
        case "Image":
            form.fields[index].data_length = 255;
            break;
        case "File":
            form.fields[index].data_length = 255;
            break;
        case "Date":
            form.fields[index].data_length = '';
            break;
        case "Time":
            form.fields[index].data_length = '';
            break;
        case "DateTime":
            form.fields[index].data_length = '';
            break;
        default:
            form.fields[index].data_length = 255;
            break;
    }
};
;

const onModelChange = (index) => {
    const modelName = form.fields[index].relation_table;
    router.visit(
        route('backend.moduleMaker', { model: modelName }),
        {
            only: ['fillableAttributes'],
            preserveState: true,
        }
    );
};


// Function to add enum value
const addEnumValue = (fieldIndex) => {
    form.fields[fieldIndex].enum_values.push({ value: "" });
};

// Function to remove enum value
const removeEnumValue = (fieldIndex, index) => {
    form.fields[fieldIndex].enum_values.splice(index, 1);
};


const formattedModelName = () => {
    let modelName = form.modelName.trim();
    modelName = modelName.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join('');
    form.modelName = modelName;
};
const formattedRelationModelName = (index) => {
    let relation_table = form.fields[index].relation_table.trim();
    relation_table = relation_table.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join('');
    form.relation_table = relation_table;
};

const formattedFieldName = (index) => {
    let field_name = form.fields[index].field_name;
    field_name = field_name.split(' ').map(word => word.charAt(0).toLowerCase() + word.slice(1)).join('_');
    form.fields[index].field_name = field_name.toLowerCase();
};
</script>

<template>
    <BackendLayout>
        <div
            class="w-full mt-3 transition duration-1000 ease-in-out transform bg-white border border-gray-700 rounded-md shadow-lg shadow-gray-800/50 dark:bg-slate-900">
            <div
                class="flex items-center justify-between w-full text-gray-700 bg-gray-100 rounded-md shadow-md dark:bg-gray-800 dark:text-gray-200 shadow-gray-800/50">
                <div>
                    <h1 class="px-4 py-3 font-bold text-md dark:text-white">
                        {{ $page.props.pageTitle }}
                    </h1>
                </div>
                <div class="px-4 py-2"></div>
            </div>

            <form @submit.prevent="submit" class="p-4">
                <AlertMessage />
                <!-- <pre>{{ form }}</pre> -->
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4">
                    <div class="col-span-1 md:col-span-2">
                        <InputLabel for="modelName" value="Model Name" />
                        <input id="modelName"
                            class="block w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600"
                            v-model="form.modelName" @input="formattedModelName" type="text" placeholder="Model Name" />
                        <InputError class="mt-2" :message="form.errors.modelName" />
                    </div>
                </div>

                <div class="w-full mt-4">
                    <InputLabel for="Database Fields" value="Database Fields" />
                    <table class="w-full text-xs gray-700 text- dark:text-gray-200">
                        <thead>
                            <tr class="text-gray-300 bg-slate-900">
                                <th class="p-2 border border-slate-600">Sl/No</th>
                                <th class="p-2 border border-slate-600">Field Name</th>
                                <th class="p-2 border border-slate-600">Data Type</th>
                                <th class="p-2 border border-slate-600">Data Length</th>
                                <th class="p-2 border border-slate-600">Default Value</th>
                                <th class="p-2 border border-slate-600">isNullable</th>
                                <th class="p-2 border border-slate-600">isRelation</th>
                                <th class="p-2 border border-slate-600">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(field, fieldIndex) in form.fields" :key="fieldIndex">
                                <tr>
                                    <td class="text-center border border-slate-600">
                                        {{ fieldIndex + 1 }}
                                    </td>
                                    <td class="p-1 border border-slate-600">
                                        <input type="text" placeholder="Database Field Name" v-model="field.field_name"
                                            @input="formattedFieldName(fieldIndex)"
                                            class="block w-full px-2 py-1 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600" />
                                        <InputError class="mt-2"
                                            :message="form.errors['fields.' + fieldIndex + '.field_name']" />
                                    </td>

                                    <td class="p-1 border border-slate-600">
                                        <select v-model="field.data_type" @change="onDataTypeChange(fieldIndex)"
                                            class="block w-full px-2 py-1 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600">
                                            <option value="">-- Select A Data Type --</option>
                                            <template v-for="(dataType, dataIndex) in $page.props.dataTypes"
                                                :key="dataIndex">
                                                <option :value="dataType">{{ dataType }}</option>
                                            </template>
                                        </select>
                                        <InputError class="mt-2"
                                            :message="form.errors['fields.' + fieldIndex + '.data_type']" />

                                        <template v-if="field.data_type === 'Enum'">
                                            <template
                                                v-for="(enumValue, enumIndex) in form.fields[fieldIndex].enum_values"
                                                :key="enumIndex">
                                                <input type="text" placeholder="Add Enum Value"
                                                    v-model="enumValue.value"
                                                    class="block w-full px-2 py-1 mt-1 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600" />
                                                <button type="button" @click="removeEnumValue(fieldIndex, enumIndex)">
                                                    <FeatherIcon name="trash-2" size="1px" class="text-red-500" />
                                                    <path d="M21 4H8l-7 8 7 8h13a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2z" />
                                                    <line x1="18" x2="12" y1="9" y2="15" />
                                                    <line x1="12" x2="18" y1="9" y2="15" />
                                                </button>
                                            </template>
                                            <button type="button" @click="addEnumValue(fieldIndex)"
                                                class="px-2 py-1 font-bold text-gray-200 rounded ">
                                                <FeatherIcon name="plus" size="1px" class="text-green-500" />
                                            </button>
                                        </template>
                                    </td>

                                    <td class="px-2 py-1 border border-slate-600 max-w-16">
                                        <input type="text" step="0.01" placeholder="Data Length"
                                            v-model="field.data_length" min="1"
                                            class="block w-full px-2 py-1 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600" />
                                        <InputError class="mt-2" :message="form.errors['fields.' + fieldIndex + '.data_length']
                            " />
                                    </td>
                                    <td class="px-2 py-1 border border-slate-600">
                                        <input type="text" placeholder="Default Value" v-model="field.default_value"
                                            class="block w-full px-2 py-1 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600" />
                                        <InputError class="mt-2"
                                            :message="form.errors['fields.' + fieldIndex + '.default_value']" />
                                    </td>

                                    <td class="px-2 py-1 border border-slate-600" style="text-align: -webkit-center;">
                                        <input type="checkbox" v-model="field.is_nullable"
                                            class="block px-2 py-1 text-sm border-2 rounded-md shadow-sm border-slate-800 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600" />
                                        <InputError class="mt-2"
                                            :message="form.errors['fields.' + fieldIndex + '.is_nullable']" />
                                    </td>

                                    <td class="px-2 py-1 border border-slate-600" style="text-align: -webkit-center;">
                                        <div class="flex items-center justify-center w-full space-x-2">
                                            <input type="checkbox" v-model="field.is_relation"
                                                class="block px-2 py-1 text-sm border-2 rounded-md shadow-sm border-slate-800 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600" />
                                            <InputError class="mt-2"
                                                :message="form.errors['fields.' + fieldIndex + '.is_relation']" />

                                            <div v-if="field.is_relation" class="w-full">
                                                <select v-model="field.relation_table"
                                                    @change="onModelChange(fieldIndex)"
                                                    class="block w-full px-2 py-1 mt-1 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600">
                                                    <option value="">-- Select a Model --</option>
                                                    <template v-for="(modelType, modelIndex) in $page.props.modelsName"
                                                        :key="modelIndex">
                                                        <option :value="modelType">{{ modelType }}</option>
                                                    </template>
                                                </select>
                                                <InputError class="mt-2"
                                                    :message="form.errors['fields.' + fieldIndex + '.relation_table']" />
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-2 py-1 border border-slate-600 text-end">
                                        <button type="button" @click="removeEnumValue(fieldIndex, enumIndex)"
                                            class="px-4 py-1 font-bold text-gray-200 rounded">
                                            <FeatherIcon name="trash-2" class="text-red-500" />
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            <tr>
                                <td colspan="8" class="px-2 py-1 border text-end border-slate-600">
                                    <button type="button" @click="addMoreField"
                                        class="px-4 py-1 font-bold text-gray-200 rounded">
                                        <FeatherIcon name="file-plus" size="1px" class="text-green-500" />
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                {{ form.formField }}
                    {{ form.relationField }}

                <div class="w-full" v-if="form.fields">
                    <div class="flex pb-1 mt-5 mb-2 border-b">
                        <h1 class="text-xl font-bold">Select column name</h1>
                    </div>
                    <div class="grid grid-cols-2 gap-1 sm:grid-cols-3">
                        <template v-for="field, Index, in form.fields" :key="Index">
                            <div class="flex items-center w-full mb-2 space-x-2">
                                <input v-if="field.field_name" :id="'from' + Index" type="checkbox" v-model="form.formField" :value="field.field_name"
                                    class="block px-2 py-1 text-sm border-2 rounded-md shadow-sm border-slate-800 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600" />
                                <label :for="'from' + Index"> {{ field.field_name }} </label>
                            </div>
                        </template>
                    </div>
                </div>

                <div v-if="fillableAttributes" class="w-full">
                    <div class="flex pb-1 mt-5 mb-2 border-b">
                        <h1 class="text-xl font-bold">Select relation table column name</h1>
                    </div>
                    <div class="grid grid-cols-2 gap-1 mt-2 sm:grid-cols-3">
                        <template v-for="field, Index, in fillableAttributes" :key="Index">
                            <div class="flex items-center w-full mb-2 space-x-2">
                                <input v-if="field" :id="'model' + Index" type="checkbox" v-model="form.relationField" :value="field"
                                    class="block px-2 py-1 text-sm border-2 rounded-md shadow-sm border-slate-800 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600" />
                                <label :for="'model' + Index"> {{ field }} </label>
                            </div>
                        </template>
                    </div>
                </div>


                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton type="submit" class="ms-4" :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing">
                        Create
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </BackendLayout>
</template>
