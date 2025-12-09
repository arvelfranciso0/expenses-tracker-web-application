<template>
    <label
        :for="for"
        :class="[
            'block font-medium  mb-1',
            sizeClass,
            disabled ? 'opacity-60 cursor-not-allowed' : '',
        ]"
    >
        <slot />

        <!-- Optional required indicator -->
        <span v-if="required" class="text-red-500 ml-1">*</span>
    </label>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    for: {
        type: String,
        default: null,
    },
    size: {
        type: String,
        default: "md", // sm | md | lg
    },
    required: {
        type: Boolean,
        default: false,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

const sizeClass = computed(() => {
    return {
        xs: "text-xs",
        sm: "text-sm text-gray-500",
        md: "text-base",
        lg: "text-lg",
    }[props.size];
});
</script>
