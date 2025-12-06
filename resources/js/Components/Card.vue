<template>
    <div
        class="bg-white shadow-md rounded-xl p-5 border border-gray-200 hover:shadow-lg transition"
    >
        <!-- Image -->
        <div v-if="image" class="mb-4">
            <img
                :src="image"
                :alt="title"
                class="w-full h-40 object-cover rounded-lg"
            />
        </div>

        <!-- Title -->
        <h3 class="text-lg font-semibold text-gray-800 mb-2">
            {{ title }}
        </h3>

        <!-- Description -->
        <p v-if="description" class="text-sm text-gray-600 mb-4">
            {{ description }}
        </p>

        <!-- Actions -->
        <div v-if="$slots.actions" class="mt-4 flex gap-2">
            <slot name="actions"></slot>
        </div>

        <!-- Default Slot (extra content) -->
        <slot />
    </div>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        default: "",
    },
    image: {
        type: String,
        default: null,
    },
});
</script>
