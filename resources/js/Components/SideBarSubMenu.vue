<script setup>
import { computed, onMounted, onUnmounted, ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
  align: {
    type: String,
    default: "right",
  },
  width: {
    type: String,
    default: "48",
  },
  contentClasses: {
    type: Array,
    default: () => ["py-1", "text-slate-800 dark:text-slate-400"],
  },
  activeRoute: {
    // type: String,
    required: true,
  },
});

let open = ref(false);

const isActiveRoute = computed(() => route().current() === props.activeRoute);

const closeOnEscape = (e) => {
  if (open.value && e.key === "Escape") {
    open.value = false;
  }
};

onMounted(() => {
  document.addEventListener("keydown", closeOnEscape);
  if (isActiveRoute.value) {
    open.value = true;
  }
});
onUnmounted(() => document.removeEventListener("keydown", closeOnEscape));

const widthClass = computed(() => {
  return {
    48: "w-full",
  }[props.width.toString()];
});

const alignmentClasses = computed(() => {
  if (props.align === "left") {
    return "ltr:origin-top-left rtl:origin-top-right start-0";
  }

  if (props.align === "right") {
    return "ltr:origin-top-right rtl:origin-top-left end-0";
  }

  return "origin-top";
});
</script>

<template>
  <div class="relative">
    <div @click="open = !open" :class="open ? 'bg-slate-800 text-white' : ''">
      <slot name="trigger" />
    </div>

    <!-- Full Screen Dropdown Overlay -->
    <div v-show="open" class="" @click="open = false" />

    <transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="transform scale-95 opacity-0"
      enter-to-class="transform scale-100 opacity-100"
      leave-active-class="transition duration-75 ease-in"
      leave-from-class="transform scale-100 opacity-100"
      leave-to-class="transform scale-95 opacity-0"
    >
      <div
        v-show="open"
        class="rounded-md"
        :class="[widthClass, alignmentClasses]"
        style="display: none"
        @click="open = false"
      >
        <div :class="[...contentClasses, open ? 'bg-gray-200' : '']">
          <slot name="content" />
        </div>
      </div>
    </transition>
  </div>
</template>
