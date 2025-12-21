<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: {
        type: String,
        default: null,
    },
    type: {
        type: String,
        default: "button",
    },
    variant: {
        type: String,
        default: "primary",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    method: {
        type: String,
        default: "get",
    },
});

const emit = defineEmits(["clicked"]);

const classes = computed(() => {
    switch (props.variant) {
        case "outline":
            return "px-4 py-2 rounded-lg border  border-gray-700 bg-gray-100 text-gray-900 hover:bg-amber-100 hover:text-gray-700 hover:bg-amber-50 transition font-medium";
        case "danger":
            return "px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition font-medium";
        case "secondary":
            return "px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-800 hover:text-gray-50 transition font-medium ";
        default:
            return "px-4 py-2 rounded-lg bg-amber-600 text-white hover:bg-amber-500  transition font-medium";
    }
});
</script>
<template>
    <Link
        v-if="href"
        :method="method"
        :href="href"
        :class="[classes, disabled ? 'opacity-50 cursor-not-allowed' : '']"
        :disabled="disabled"
    >
        <slot />
    </Link>

    <!-- Otherwise → render <button> -->
    <button
        v-else
        :type="type"
        :disabled="disabled"
        :class="[classes, disabled ? 'opacity-50 cursor-not-allowed' : '']"
        @click="emit('clicked')"
    >
        <slot />
    </button>
</template>
