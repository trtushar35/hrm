<script setup>
import { statusChangeConfirmation, deleteConfirmation } from '@/responseMessage.js';
import $ from 'jquery';

$(function () {
    $('.statusChange').on('click', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');
        statusChangeConfirmation(url);
    });
    $('.deleteButton').on('click', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');
        deleteConfirmation(url);
    });
});
</script>
<template>
    <table class="w-full text-gray-700 dark:text-gray-200">
        <thead class="text-gray-700 uppercase bg-slate-300 dark:bg-gray-700 dark:text-gray-200">
            <tr class="text-[12px] shadow-md shadow-gray-800/50">
                <template v-for="header in $page.props.tableHeaders" >
                    <th scope="col" class="px-6 py-3 border border-slate-600">{{ header }}</th>
                </template>
            </tr>
        </thead>
        <tbody class="text-[12px] 2xl:text-[14px]">
            <template v-for="(data, dataIndex) in $page.props.datas">
                <tr class="duration-500 hover:bg-gray-100 dark:hover:bg-gray-800 hover:shadow-md shadow-gray-800/50">
                    <template v-for="(dateField, dateFieldIndex) in $page.props.dataFields">
                        <td class="px-4 py-2 border border-slate-700" :class="dateField.class">
                            <p v-html="data[dateField.fieldName] ?? ''"></p>
                        </td>
                    </template>
                    <template v-if="data.hasLink">
                        <td class="px-4 py-2 border border-slate-700">
                            <div class="flex justify-center w-full space-x-1">
                                <template v-for="(linkInfo, linkIndex) in data.links">
                                    <a class="px-3 py-1 duration-500 rounded hover:shadow-lg hover:bg-green-500"
                                        :href="linkInfo.link" :class="linkInfo.linkClass">
                                        <span v-html="linkInfo.linkLabel"></span>
                                    </a>
                                </template>
                            </div>
                        </td>
                    </template>
                </tr>
            </template>
        </tbody>
    </table>
</template>
