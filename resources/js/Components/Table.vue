<template>
    <div
        class="overflow-x-auto rounded-xl border border-gray-200 bg-white dark:bg-gray-700"
    >
        <table class="min-w-full text-left text-sm">
            <!-- Table Head -->
            <thead class="bg-gray-50 border-b dark:bg-gray-800">
                <tr>
                    <th
                        v-for="(header, index) in headers"
                        :key="index"
                        class="px-4 py-3 font-semibold text-gray-700 dark:text-gray-50"
                    >
                        {{ header }}
                    </th>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody>
                <slot />
            </tbody>
        </table>
    </div>
</template>

<script setup>
defineProps({
    headers: {
        type: Array,
        required: true,
    },
});
</script>
