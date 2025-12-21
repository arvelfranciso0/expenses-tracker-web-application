<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";

const isDark = ref(false);

onMounted(() => {
    const saved = localStorage.getItem("theme");

    if (saved) {
        isDark.value = saved === "dark";
    } else {
        // Auto detect OS theme
        isDark.value = window.matchMedia(
            "(prefers-color-scheme: dark)"
        ).matches;
    }

    applyTheme();
});

const applyTheme = () => {
    const root = document.documentElement;
    isDark.value ? root.classList.add("dark") : root.classList.remove("dark");
};
</script>

<template>
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-800"
    >
        <!-- <div>
            <Link href="/">
                <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
            </Link>
        </div> -->

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:text-gray-50 dark:bg-gray-900 shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
