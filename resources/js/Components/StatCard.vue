<template>
    <div
        :class="[
            'shadow-sm border rounded-xl p-5 flex items-center justify-between',
            is_active
                ? 'border-amber-100 dark:border-indigo-900 bg-amber-600 dark:bg-indigo-950/50'
                : 'bg-white dark:bg-gray-800',
        ]"
    >
        <div>
            <p
                :class="[
                    'text-sm',
                    is_active
                        ? 'text-white'
                        : ' text-gray-500 dark:text-gray-50',
                ]"
            >
                {{ label }}
            </p>
            <h2
                :class="[
                    'text-2xl font-semibold mt-1',
                    is_active
                        ? 'text-white'
                        : ' ext-gray-800  dark:text-gray-50',
                ]"
            >
                {{ value }}
            </h2>
        </div>

        <div
            v-if="icon"
            :class="[
                'text-4xl',
                is_active ? 'text-white' : ' text-gray-500 dark:text-gray-50',
            ]"
        >
            <component :is="icon" />
        </div>
    </div>
</template>

<script setup>
defineProps({
    label: String,
    value: [String, Number],
    is_active: [Boolean],
    icon: {
        type: [Object, Function],
        default: null,
    },
});
</script>
