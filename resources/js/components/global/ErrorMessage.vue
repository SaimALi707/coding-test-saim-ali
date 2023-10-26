<template>
    <p class="mt-2 text-sm text-red-600">{{ errorMsg }}</p>
</template>

<script setup>

const props = defineProps({
    errorMsg: {
        type: String,
        required: true
    }
})
</script>
