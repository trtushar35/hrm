<template>
    <div>
        <div v-if="$page.props.flash.successMessage"
            class="p-4 mb-1 text-green-600 bg-green-300 border-green-500 shadow-md alert">
            {{ $page.props.flash.successMessage }}
        </div>
        <div v-if="$page.props.flash.errorMessage" class= "p-4 mb-1 text-white bg-red-500 bg-opacity-75 shadow-md alert">
            {{ $page.props.flash.errorMessage }}
        </div>
        <div v-if="$page.props.flash.warningMessage"
            class="p-4 mb-1 text-yellow-500 bg-yellow-100 border-yellow-300 shadow-md alert">
            {{ $page.props.flash.warningMessage }}
        </div>
        <!-- <template v-if="$page.props.errorBags" v-for="errorKey in  Object.keys($page.props.errorBags.default)">
            <div class="p-4 text-red-500 bg-yellow-200 border-yellow-500 shadow-md alert">
                {{ $page.props.errorBags.default[errorKey] }}
            </div>
        </template> -->
    </div>
</template>
