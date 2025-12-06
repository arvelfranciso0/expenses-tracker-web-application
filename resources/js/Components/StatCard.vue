<template>
    <div
        class="bg-white dark:bg-gray-800 shadow-sm border rounded-xl p-5 flex items-center justify-between"
    >
        <div>
            <p class="text-sm text-gray-500 dark:text-gray-50">{{ label }}</p>
            <h2
                class="text-2xl font-semibold text-gray-800 mt-1 dark:text-gray-50"
            >
                {{ value }}
            </h2>
        </div>

        <div v-if="icon" class="text-gray-400 text-4xl dark:text-gray-50">
            <component :is="icon" />
        </div>
    </div>
</template>

<script setup>
defineProps({
    label: String,
    value: [String, Number],
    icon: {
        type: [Object, Function],
        default: null,
    },
});
</script>
