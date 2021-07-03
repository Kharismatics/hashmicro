<template>
    <button :type="type" :class="classvalue">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'submit',
            },
            classvalue: {
                type: String,
                default: 'inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-400 active:bg-green-600 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150',
            },
        }
    }
</script>
