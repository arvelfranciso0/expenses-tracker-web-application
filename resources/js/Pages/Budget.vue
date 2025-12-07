<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Select from "@/Components/Select.vue";
</script>

<template>
    <AuthenticatedLayout>
        <div class="container">
            <!-- Current Active Budget Select -->
            <section class="rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">
                    Current Active Budget
                </h2>
                <Select>
                    <option value="1" selected>Marketing Budget</option>
                </Select>
            </section>

            <!-- Create New Budget Form -->
            <section class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Create New Budget</h2>
                <form class="space-y-4">
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Budget Name</label
                        >
                        <input
                            type="text"
                            placeholder="Enter budget name"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:border-indigo-500"
                        />
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Amount</label
                        >
                        <input
                            type="number"
                            placeholder="Enter budget amount"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:border-indigo-500"
                        />
                    </div>

                    <button
                        type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                    >
                        Create Budget
                    </button>
                </form>
            </section>

            <!-- Budgets Table -->
            <section class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">All Budgets</h2>
                <div class="overflow-x-auto">
                    <table
                        class="min-w-full border border-gray-200 divide-y divide-gray-200"
                    >
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase"
                                >
                                    ID
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase"
                                >
                                    Name
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase"
                                >
                                    Amount
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase"
                                >
                                    Status
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    1
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    Marketing Budget
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    $5,000
                                </td>
                                <td
                                    class="px-6 py-4 text-sm text-green-600 font-semibold"
                                >
                                    Active
                                </td>
                                <td
                                    class="px-6 py-4 text-sm text-gray-700 space-x-2"
                                >
                                    <button
                                        class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    2
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    Development Budget
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    $10,000
                                </td>
                                <td
                                    class="px-6 py-4 text-sm text-gray-500 font-semibold"
                                >
                                    Inactive
                                </td>
                                <td
                                    class="px-6 py-4 text-sm text-gray-700 space-x-2"
                                >
                                    <button
                                        class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            <!-- Add more static rows as needed -->
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
