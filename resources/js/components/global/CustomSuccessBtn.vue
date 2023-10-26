<template>
    <button type="button"
            class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
            @click="clickBtn">
        {{ btnTitle }}
    </button>
</template>

<script setup>
const emit = defineEmits(["click"])
const props = defineProps({
    btnTitle: {
        type: String,
        required: true
    },
    customClass: {
        type: String,
        default: null,
    }
});

const clickBtn = function (phase) {
    emit('click')
}
</script>
