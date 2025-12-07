<script setup>
import { usePage } from "@inertiajs/vue3";
import { ref, onMounted, computed } from "vue";
import { CircleUserRound, Moon, Sun, Menu } from "lucide-vue-next";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
const sidebarOpen = ref(false);
const page = usePage();
const title = computed(() => page.props.title || "Default Title");

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

const toggleTheme = () => {
    isDark.value = !isDark.value;
    localStorage.setItem("theme", isDark.value ? "dark" : "light");
    applyTheme();
};

const applyTheme = () => {
    const root = document.documentElement;
    isDark.value ? root.classList.add("dark") : root.classList.remove("dark");
};
</script>

<template>
    <div
        class="flex h-screen bg-gray-100 dark:bg-gray-700 dark:text-gray-100 text-gray-900"
    >
        <aside
            :class="[
                'fixed z-20 inset-y-0 left-0 w-64 shadow-lg transform transition-transform duration-300',
                'bg-white dark:bg-gray-800',
                sidebarOpen ? 'translate-x-0' : '-translate-x-full',
                'lg:translate-x-0 lg:static',
            ]"
        >
            <div class="h-16 flex items-center px-6 border-b border-gray-200">
                <h1 class="text-xl font-bold text-amber-600">
                    Expenses Tracker
                </h1>
            </div>

            <nav class="mt-4 space-y-1">
                <Link
                    :href="route('dashboard.index')"
                    class="block px-5 py-3 text-gray-700 dark:text-gray-100 hover:bg-amber-50 dark:hover:text-amber-600 hover:text-amber-600 font-medium transition"
                >
                    Dashboard
                </Link>

                <Link
                    :href="route('expense.index')"
                    class="block px-5 py-3 text-gray-700 dark:text-gray-100 hover:bg-amber-50 dark:hover:text-amber-600 hover:text-amber-600 font-medium transition"
                >
                    Expenses
                </Link>

                <Link
                    :href="route('profile.edit')"
                    class="block px-5 py-3 text-gray-700 dark:text-gray-100 hover:bg-amber-50 dark:hover:text-amber-600 hover:text-amber-600 font-medium transition"
                >
                    Profile
                </Link>

                <!-- <Link
                    :href="route('profile')"
                    class="block px-5 py-3 text-gray-700 hover:bg-amber-50 hover:text-amber-600 font-medium transition"
                >
                    Profile
                </Link>

                <Link
                    :href="route('settings')"
                    class="block px-5 py-3 text-gray-700 hover:bg-amber-50 hover:text-amber-600 font-medium transition"
                >
                    Settings
                </Link> -->
            </nav>
        </aside>

        <div
            v-if="sidebarOpen"
            class="fixed inset-0 bg-black bg-opacity-50 z-10 lg:hidden"
            @click="sidebarOpen = false"
        ></div>

        <div class="flex-1 flex flex-col">
            <header
                class="flex items-center justify-between bg-white dark:bg-gray-700 shadow px-6 h-16 border-b border-gray-200"
            >
                <button
                    @click="sidebarOpen = true"
                    class="lg:hidden text-gray-700"
                >
                    <Menu />
                </button>

                <h1
                    class="text-xl font-semibold text-gray-800 dark:text-gray-50"
                >
                    {{ title }}
                </h1>

                <div class="flex items-center space-x-3">
                    <span
                        class="text-gray-500 dark:text-gray-100 text-sm hidden sm:block"
                    >
                        Hello, {{ $page.props.auth.user.name }}
                    </span>

                    <CircleUserRound class="w-6 h-6" />

                    <button
                        @click="toggleTheme"
                        class="p-2 rounded-md hover:text-amber-600 transition"
                    >
                        <Sun v-if="isDark" class="w-6 h-6" />

                        <Moon v-else class="w-6 h-6" />
                    </button>
                </div>
            </header>

            <!-- Content Body -->
            <main class="p-6 overflow-y-auto flex-1 dark:bg-gray-700">
                <Head :title="title" />
                <slot />
            </main>
        </div>
    </div>
</template>
