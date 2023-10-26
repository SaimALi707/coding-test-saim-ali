<template>
    <select @change="onInputChange" :value="modelValue" class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
        <option value="" selected disabled>Select</option>
        <option v-for="select in selectOptions" :key="select.id" :value="select.id">
            {{ select.name }}
        </option>
    </select>
</template>

<script setup>
const emit = defineEmits(["update"])

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: null,
    },
    selectOptions: {
        type: [Array, Object],
        required: true
    },
    selectedItem: {
        type: String,
        default: null,
    }
});

const onInputChange = (e) => {
    console.log("Event: ", e.target.value)
    emit('update:modelValue', e.target.value)
}
</script>
