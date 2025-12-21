<script setup>
import { usePage } from "@inertiajs/vue3";
import { ref, onMounted, computed, watch } from "vue";
import { CircleUserRound, Moon, Sun, Menu, LogOut } from "lucide-vue-next";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import Toast from "@/Components/Toast.vue";

const sidebarOpen = ref(false);
const page = usePage();
const title = computed(() => page.props.title || "Default Title");
const isDark = ref(false);
const toastRef = ref(null);

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
watch(
    () => page.props.flash,
    (flash) => {
        if (flash.success) {
            toastRef.value.addToast({
                message: flash.success,
                type: "success",
            });
        }
        if (flash.error) {
            toastRef.value.addToast({
                message: flash.error,
                type: "error",
            });
        }
    },
    { deep: true }
);
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
                    :class="
                        page.url.startsWith('/dashboard')
                            ? 'dark:bg-gray-700 dark:text-amber-600 bg-amber-100 text-amber-600'
                            : 'dark:text-gray-100 text-gray-700 '
                    "
                    class="block px-5 py-3 hover:bg-amber-50 dark:hover:bg-gray-700 dark:hover:text-amber-600 font-medium transition"
                >
                    Dashboard
                </Link>

                <Link
                    :href="route('expense.index')"
                    :class="
                        page.url.startsWith('/expense')
                            ? 'dark:bg-gray-700 dark:text-amber-600 bg-amber-100 text-amber-600'
                            : 'dark:text-gray-100 text-gray-700 '
                    "
                    class="block px-5 py-3 hover:bg-amber-50 dark:hover:bg-gray-700 dark:hover:text-amber-600 font-medium transition"
                >
                    Expenses
                </Link>

                <Link
                    :href="route('budget.index')"
                    :class="
                        page.url.startsWith('/budget')
                            ? 'dark:bg-gray-700 dark:text-amber-600 bg-amber-100 text-amber-600'
                            : 'dark:text-gray-100 text-gray-700 '
                    "
                    class="block px-5 py-3 hover:bg-amber-50 dark:hover:bg-gray-700 dark:hover:text-amber-600 font-medium transition"
                >
                    Budget
                </Link>

                <Link
                    :href="route('profile.edit')"
                    :class="
                        page.url.startsWith('/profile')
                            ? 'dark:bg-gray-700 dark:text-amber-600 bg-amber-100 text-amber-600'
                            : 'dark:text-gray-100 text-gray-700 '
                    "
                    class="block px-5 py-3 hover:bg-amber-50 dark:hover:bg-gray-700 dark:hover:text-amber-600 font-medium transition"
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
                    class="lg:hidden text-gray-700 dark:text-gray-50"
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

                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="hover:text-amber-600 transition"
                    >
                        <LogOut class="w-6 h-6" />
                    </Link>
                </div>
                <!-- <div class="ms-3 relative">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button
                                    type="button"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-600 dark:text-gray-50 focus:outline-none transition ease-in-out duration-150"
                                >
                                    {{ $page.props.auth.user.name }}

                                    <svg
                                        class="ms-2 -me-0.5 h-4 w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <DropdownLink :href="route('profile.edit')">
                                Profile
                            </DropdownLink>
                            <DropdownLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div> -->
            </header>

            <!-- Content Body -->
            <main class="p-6 overflow-y-auto flex-1 dark:bg-gray-700">
                <Head :title="title" />
                <slot />
            </main>
            <Toast ref="toastRef" />
        </div>
    </div>
</template>
