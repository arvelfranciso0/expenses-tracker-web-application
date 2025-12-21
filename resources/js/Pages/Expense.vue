<script setup>
import TextInput from "@/Components/TextInput.vue";
import Textarea from "@/Components/Textarea.vue";
import Select from "@/Components/Select.vue";
import Button from "@/Components/Button.vue";
import Table from "@/Components/Table.vue";
import Label from "@/Components/Label.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Section from "@/Components/Section.vue";
import { useForm } from "@inertiajs/vue3";
import {
    DollarSign,
    Tag,
    Calendar,
    ChevronDown,
    CheckCircle,
    XCircle,
} from "lucide-vue-next";
import dayjs from "dayjs";
import { formatAmount } from "@/composables/useCurrency";

const props = defineProps({
    data: Object,
    categories: Array,
    budget: Object,
});

const form = useForm({
    amount: "",
    category_id: "",
    expenses_date: "",
    description: "",
    // Use optional chaining for safer access
    budget_id: props.budget?.is_active ? props.budget.id : "",
});

const submit = () => {
    // The original logic to format date is good, but for type="date" input, the value is usually already in 'YYYY-MM-DD' format.
    // However, keeping the safety check just in case.
    if (form.expenses_date && form.expenses_date.includes("/")) {
        form.expenses_date = form.expenses_date.replace(/\//g, "-");
    }

    form.post(route("expense.store"), {
        onSuccess: () => form.reset(),
        onError: (errors) => console.log(errors),
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="space-y-6 p-4 sm:p-6">
            <h1
                class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 border-b pb-2"
            >
                Manage Expenses
            </h1>

            <div class="flex flex-col lg:flex-row gap-6">
                <Section
                    class="w-full lg:w-1/3 shadow-lg p-6 bg-white dark:bg-gray-800 rounded-xl"
                >
                    <h2
                        class="text-xl font-semibold mb-6 text-gray-800 dark:text-gray-100"
                    >
                        Add New Expense
                    </h2>

                    <form @submit.prevent="submit" class="flex flex-col gap-6">
                        <div class="space-y-1">
                            <Label size="sm" for="budget_id"
                                >Active Budget</Label
                            >
                            <Select
                                id="budget_id"
                                v-model="form.budget_id"
                                :required="true"
                                :disabled="true"
                                class="w-full"
                            >
                                <option :value="props.budget?.id">
                                    {{
                                        props.budget?.source ||
                                        "No Active Budget"
                                    }}
                                </option>
                            </Select>
                            <p
                                v-if="props.budget"
                                class="text-xs text-green-600 dark:text-green-400 mt-1"
                            >
                                Expense will be logged against this budget.
                            </p>
                            <p
                                v-else
                                class="text-xs text-red-600 dark:text-red-400 mt-1"
                            >
                                No active budget found. Expense will be
                                unassigned.
                            </p>
                        </div>

                        <div class="space-y-1">
                            <Label size="sm" for="amount"
                                >Amount ({{
                                    $page.props.auth.user.currency
                                }})</Label
                            >
                            <div class="relative">
                                <TextInput
                                    id="amount"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    class="w-full pl-10"
                                    required
                                    v-model="form.amount"
                                    placeholder="e.g. 45.99"
                                />
                                <Label
                                    size="lg"
                                    class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"
                                    >{{ $page.props.auth.user.currency }}</Label
                                >
                            </div>
                        </div>

                        <div class="space-y-1">
                            <div class="flex gap-2">
                                <Label size="sm" for="category_id"
                                    >Category</Label
                                >
                                <Tag class="w-5 h-5 text-gray-400" />
                            </div>

                            <Select
                                id="category_id"
                                v-model="form.category_id"
                                placeholder="Select category"
                                :required="true"
                                class="w-full"
                            >
                                <option value="" disabled>
                                    Select category
                                </option>
                                <option
                                    v-for="category in props.categories"
                                    :key="category.id"
                                    :value="category.id"
                                >
                                    {{ category.name }}
                                </option>
                            </Select>
                        </div>

                        <div class="space-y-1">
                            <Label size="sm" for="expenses_date"
                                >Date of Expense</Label
                            >
                            <div class="relative">
                                <TextInput
                                    id="expenses_date"
                                    type="date"
                                    class="w-full pl-10"
                                    required
                                    v-model="form.expenses_date"
                                />
                                <Calendar
                                    class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"
                                />
                            </div>
                        </div>

                        <div class="space-y-1">
                            <Label size="sm" for="description"
                                >Description (Max 50 characters)</Label
                            >
                            <Textarea
                                id="description"
                                rows="3"
                                v-model="form.description"
                                maxlength="50"
                                placeholder="e.g. Dinner with clients"
                                class="w-full"
                            />
                        </div>

                        <Button
                            :class="{ 'opacity-75': form.processing }"
                            :disabled="form.processing"
                            type="submit"
                            class="justify-center mt-2"
                        >
                            Add Expense
                        </Button>
                    </form>
                </Section>

                <Section
                    class="w-full lg:w-2/3 shadow-lg p-6 bg-white dark:bg-gray-800 rounded-xl"
                >
                    <h2
                        class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100"
                    >
                        Expense History
                    </h2>

                    <Table
                        :headers="[
                            'Category',
                            'Amount',
                            'Budget',
                            'Date',

                            'Description',
                        ]"
                    >
                        <tr
                            v-for="expense in props.data?.expenses"
                            :key="expense.id"
                            class="border-b hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150"
                        >
                            <td
                                class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100"
                            >
                                {{ expense?.category.name || "Uncategorized" }}
                            </td>
                            <td class="px-4 py-3 text-red-600 font-semibold">
                                {{ $page.props.auth.user.currency }}
                                {{ formatAmount(expense.amount) }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ expense?.category.name || "N/A" }}
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

                            <td
                                class="px-4 py-3 max-w-xs truncate text-sm text-gray-500 dark:text-gray-400"
                                :title="expense.description"
                            >
                                {{ expense.description }}
                            </td>
                        </tr>
                        <tr
                            v-if="
                                !props.data?.expenses ||
                                props.data?.expenses.length === 0
                            "
                        >
                            <td
                                colspan="6"
                                class="px-4 py-6 text-center text-gray-500 dark:text-gray-400"
                            >
                                No expenses recorded yet. Start by adding one in
                                the form on the left!
                            </td>
                        </tr>
                    </Table>
                </Section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
