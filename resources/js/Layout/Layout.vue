<script setup>
import { usePage } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";

const page = usePage();
const title = page.props.title || "Default Title";

const theme = ref("light");

// Load saved theme from localStorage
onMounted(() => {
    theme.value = localStorage.getItem("theme") || "dark";
    document.documentElement.setAttribute("data-theme", theme.value);
    console.log("Theme set to:", theme.value);
});
</script>

<template>
    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">MyApp</div>

            <nav class="nav-links">
                <a href="/" class="nav-item">Dashboard</a>
                <a href="/expenses" class="nav-item">Expenses</a>
                <a href="/profile" class="nav-item">Profile</a>
                <a href="/settings" class="nav-item">Settings</a>
            </nav>
        </aside>

        <!-- Content area -->
        <div class="content">
            <header class="header">
                <h1>{{ title }}</h1>
            </header>

            <main class="main">
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>
/* Layout wrapper */
.layout {
    display: flex;
    height: 100vh;
    overflow: hidden;
    background: var(--bg);
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

/* Sidebar */
.sidebar {
    width: 240px;
    background: var(--primary);
    color: var(--text);
    display: flex;
    flex-direction: column;
    padding: 20px 0;
}

/* Logo */
.logo {
    font-size: 24px;
    font-weight: bold;
    padding: 0 20px;
    margin-bottom: 30px;
}

/* Nav links */
.nav-links {
    display: flex;
    flex-direction: column;
}

.nav-item {
    color: var(--text);
    text-decoration: none;
    padding: 12px 20px;
    border-radius: 6px;
    margin: 4px 0;
    transition: 0.2s ease-in-out;
}

.nav-item:hover {
    background: #333;
    color: white;
}

.nav-item.active {
    background: var(--primary);
    color: var(--text);
}

/* Content area */
.content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* Header */
.header {
    background: var(--bg);
    padding: 0.5rem 1rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

/* Main content */
.main {
    padding: 20px;
    overflow-y: auto;
}
</style>
