<template>
    <select v-model="$parent.filters.numOfData" @change="$parent.applyFilter()"
        class="w-full p-2 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-500 dark:bg-slate-700 dark:text-slate-200 focus:border-indigo-300 dark:focus:border-slate-600">
        <option value="10">Show 10</option>
        <option value="20">Show 20</option>
        <option value="30">Show 30</option>
        <option value="40">Show 40</option>
        <option value="100">Show 100</option>
        <option value="150">Show 150</option>
        <option value="500">Show 500</option>
    </select>
</template>