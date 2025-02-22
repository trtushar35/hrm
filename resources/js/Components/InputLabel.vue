<script setup>
defineProps({
    value: String,
    optional_data: String,
});
</script>

<template>
    <label class="block font-bold text-sm text-slate-700 mb-1 dark:text-slate-400 transition duration-1000 ease-in-out">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>

        <span v-if="optional_data" v-html="optional_data"></span>
        <span v-else><slot /></span>
    </label>
</template>
