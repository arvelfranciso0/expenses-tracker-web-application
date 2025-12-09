<script setup>
import StatCard from "@/Components/StatCard.vue";
import {
    Landmark,
    Banknote,
    PiggyBank,
    Plus,
    TrendingDown,
} from "lucide-vue-next"; // Added TrendingDown for another metric
import Button from "@/Components/Button.vue";
import Table from "@/Components/Table.vue";
import Label from "@/Components/Label.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import dayjs from "dayjs";
import { formatAmount } from "@/composables/useCurrency";

const props = defineProps({
    data: Object,
});

// Helper for the helper text
const activeBudgetDateRange = props.data?.active_budget
    ? `(${dayjs(props.data.active_budget.start_date).format("MMM D")} - ${dayjs(
          props.data.active_budget.end_date
      ).format("MMM D, YYYY")})`
    : "(No active budget)";
</script>

<template>
    <AuthenticatedLayout>
        <div class="flex flex-col gap-6">
            <div
                class="flex flex-col sm:flex-row gap-4 justify-between items-center"
            >
                <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
                    Financial Overview
                </h1>
                <div class="flex gap-3">
                    <Button
                        :href="route('expense.index')"
                        class="inline-flex items-center gap-2 px-4 py-2"
                        variant="primary"
                    >
                        <Plus class="w-5 h-5" /> Add Expense
                    </Button>
                    <Button
                        :href="route('budget.index')"
                        variant="secondary"
                        class="inline-flex items-center gap-2 px-4 py-2"
                    >
                        <Landmark class="w-5 h-5" /> Budgets
                    </Button>
                </div>
            </div>

            <hr class="border-gray-200 dark:border-gray-700" />

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <StatCard
                    label="Current Budget Limit"
                    :value="`${$page.props.auth.user.currency} ${formatAmount(
                        props.data?.active_budget?.amount_limit ?? 0
                    )}`"
                    :icon="Landmark"
                    :helper-text="activeBudgetDateRange"
                    class="shadow-lg border border-indigo-100 dark:border-indigo-900 bg-indigo-50 dark:bg-indigo-950/50"
                />

                <StatCard
                    label="Remaining Budget"
                    :value="`${$page.props.auth.user.currency} ${formatAmount(
                        props.data?.another_metric ?? 0
                    )}`"
                    :icon="PiggyBank"
                    helper-text="Remaining amount for active budget"
                    class="shadow-lg"
                />

                <StatCard
                    label="Total Monthly Expenses"
                    :value="`${$page.props.auth.user.currency} ${formatAmount(
                        props.data?.expenses_monthly ?? 0
                    )}`"
                    :icon="Banknote"
                    helper-text="This calendar month's spend"
                    class="shadow-lg"
                />

                <StatCard
                    label="Total Yearly Expenses"
                    :value="`${$page.props.auth.user.currency} ${formatAmount(
                        props.data?.expenses_yearly ?? 0
                    )}`"
                    :icon="TrendingDown"
                    helper-text="Year-to-date total spend"
                    class="shadow-lg"
                />
            </div>

            <div class="flex flex-col lg:flex-row gap-6 mt-4">
                <div class="w-full lg:w-1/2">
                    <Label
                        size="lg"
                        class="mb-3 block text-xl font-semibold text-gray-700 dark:text-gray-200"
                        >Recent Expenses</Label
                    >
                    <Table
                        :headers="['Category', 'Amount', 'Description', 'Date']"
                    >
                        <tr
                            v-for="expense in props.data?.expenses"
                            :key="expense.id"
                            class="border-b hover:bg-gray-50 dark:hover:bg-gray-700 dark:hover:text-gray-50 transition duration-150"
                        >
                            <td class="px-4 py-3 font-medium">
                                {{ expense?.category.name }}
                            </td>
                            <td class="px-4 py-3 text-red-600 font-semibold">
                                {{ $page.props.auth.user.currency }}
                                {{ formatAmount(expense.amount) }}
                            </td>
                            <td
                                class="px-4 py-3 max-w-xs truncate text-sm text-gray-500 dark:text-gray-400"
                            >
                                {{ expense.description || "N/A" }}
                            </td>
                            <td
                                class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400"
                            >
                                {{
                                    dayjs(expense.expenses_date).format(
                                        "MMM D, YYYY"
                                    )
                                }}
                            </td>
                        </tr>
                        <tr
                            v-if="
                                !props.data?.expenses ||
                                props.data?.expenses.length === 0
                            "
                        >
                            <td
                                colspan="4"
                                class="px-4 py-6 text-center text-gray-500 dark:text-gray-400"
                            >
                                No recent expenses found. Add one now!
                            </td>
                        </tr>
                    </Table>
                </div>

                <div class="w-full lg:w-1/2">
                    <Label
                        size="lg"
                        class="mb-3 block text-xl font-semibold text-gray-700 dark:text-gray-200"
                        >Recent Budgets</Label
                    >
                    <Table :headers="['Amount Limit', 'Source', 'Set Date']">
                        <tr
                            v-for="budget in props.data?.budgets"
                            :key="budget.id"
                            class="border-b hover:bg-gray-50 dark:hover:bg-gray-700 dark:hover:text-gray-50 transition duration-150"
                        >
                            <td class="px-4 py-3 text-green-600 font-semibold">
                                {{ $page.props.auth.user.currency }}
                                {{ formatAmount(budget.amount_limit ?? 0) }}
                            </td>
                            <td class="px-4 py-3 font-medium">
                                {{ budget.source || "N/A" }}
                            </td>
                            <td
                                class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400"
                            >
                                {{
                                    dayjs(budget.created_at).format(
                                        "MMM D, YYYY"
                                    )
                                }}
                            </td>
                        </tr>
                        <tr
                            v-if="
                                !props.data?.budgets ||
                                props.data?.budgets.length === 0
                            "
                        >
                            <td
                                colspan="3"
                                class="px-4 py-6 text-center text-gray-500 dark:text-gray-400"
                            >
                                No recent budget entries found.
                            </td>
                        </tr>
                    </Table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
