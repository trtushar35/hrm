<template>
    <!-- <svg v-html="icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg" :class="classes"></svg> -->
    <i v-html="icon" :class="classes"></i>
 </template>

  <script>
  import feather from 'feather-icons';

  export default {
    props: {
      name: {
        type: String,
        required: true,
      },
      size: {
        type: [String, Number],
        default: '5px',
      },
      class: {
        type: String,
        default: '',
      },
    },
    computed: {
      icon() {
        return feather.icons[this.name].toSvg();
      },
      classes() {
        return `feather feather-${this.name} ${this.class}`;
      },
    },
  };
  </script>
