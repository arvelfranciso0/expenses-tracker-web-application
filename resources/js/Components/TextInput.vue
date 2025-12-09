<script setup>
import { onMounted, ref } from "vue";
const input = ref(null);

const model = defineModel({
    type: [String, Number],
    required: true,
});

const props = defineProps({
    disable: {
        type: Boolean,
        default: false,
    },
});

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-gray-800"
        v-model="model"
        ref="input"
        :disabled="disable"
    />
</template>
