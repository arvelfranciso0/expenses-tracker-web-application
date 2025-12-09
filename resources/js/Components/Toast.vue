<script setup>
import { reactive, computed } from "vue";

const toasts = reactive([]); // holds active toasts

// Add a toast
const addToast = ({ message, type = "success", duration = 3000 }) => {
    const id = Date.now();
    toasts.push({ id, message, type });

    // Auto-remove after duration
    setTimeout(() => removeToast(id), duration);
};

// Remove a toast
const removeToast = (id) => {
    const index = toasts.findIndex((t) => t.id === id);
    if (index !== -1) toasts.splice(index, 1);
};

// Expose globally
defineExpose({ addToast });
</script>

<template>
    <div class="fixed bottom-5 right-5 flex flex-col space-y-2 z-50">
        <TransitionGroup
            name="toast"
            tag="div"
            class="flex flex-col space-y-2"
            enter-active-class="transition transform duration-300 ease-out"
            enter-from-class="opacity-0 translate-y-2"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition transform duration-300 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-2"
        >
            <div
                v-for="toast in toasts"
                :key="toast.id"
                :class="[
                    'px-4 py-2 rounded shadow text-white font-medium cursor-pointer ',
                    toast.type === 'success'
                        ? 'bg-green-500'
                        : toast.type === 'error'
                        ? 'bg-red-500'
                        : toast.type === 'warning'
                        ? 'bg-yellow-500'
                        : 'bg-gray-500',
                ]"
                @click="removeToast(toast.id)"
            >
                {{ toast.message }}
            </div>
        </TransitionGroup>
    </div>
</template>
