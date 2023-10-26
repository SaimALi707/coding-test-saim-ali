<template>
    <div class="relative">
        <input :type="inputType"
               :value="modelValue"
               @input="onInputChange"
               :class="customClass"
               class="peer block w-full border-0 bg-gray-50 py-1.5 text-gray-900 focus:ring-0 sm:text-sm sm:leading-6"
               :placeholder="inputPlaceholder" />
    </div>
</template>

<script setup>
const emit = defineEmits(["update"])

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: null,
    },
    inputPlaceholder: {
        type: String,
        default: null
    },
    inputType: {
        type: String,
        required: true
    },
    customClass: {
        type: String,
        default: ''
    }
})
const onInputChange = (e) => {
    console.log("Event: ", e.target.value)
    emit('update:modelValue', e.target.value)
}
</script>
