<script setup>
import { defineProps, defineEmits } from "vue";

const props = defineProps({
    modelValue: [String, Number],
    placeholder: { type: String, default: "Select an option" },
    options: { type: Array, required: true },
});

const emit = defineEmits(["update:modelValue"]);
</script>

<template>
    <select
        :value="props.modelValue"
        @change="emit('update:modelValue', $event.target.value)"
        class="border border-gray-300 rounded-lg px-3 dark:bg-gray-800 w-full py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700 dark:text-gray-50"
    >
        <option value="" disabled hidden>{{ props.placeholder }}</option>
        <option
            v-for="option in props.options"
            :key="option.value"
            :value="option.value"
        >
            {{ option.label }}
        </option>
    </select>
</template>
