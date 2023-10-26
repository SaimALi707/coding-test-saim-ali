<template>
    <label class="block text-sm font-medium leading-6 text-gray-900">{{ inputLabel }}</label>
</template>

<script setup>

const props = defineProps({
    inputLabel: {
        type: String,
        required: true
    },
})
</script>
