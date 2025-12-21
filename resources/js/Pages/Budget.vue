<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Label from "@/Components/Label.vue";
import Section from "@/Components/Section.vue";
import TextInput from "@/Components/TextInput.vue";
import Button from "@/Components/Button.vue";
import Table from "@/Components/Table.vue";
import { useForm, router } from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import dayjs from "dayjs";
import { formatAmount } from "@/composables/useCurrency";
import { ref } from "vue";

const props = defineProps({
    budgets: Array,
    activeBudget: Object,
});
const showModal = ref(false);
const selectedBudget = ref(null);

const budgetForm = useForm({
    amount_limit: "",
    source: "",
});

const editBudgetForm = useForm({
    amount_limit: "",
    source: "",
});

const openEditBudgetModal = (budget) => {
    selectedBudget.value = { ...budget };
    editBudgetForm.reset();
    editBudgetForm.source = budget.source;
    editBudgetForm.amount_limit = budget.amount_limit;
    showModal.value = true;
    console.log(budget);
};

const closeEditBudgetModal = () => {
    showModal.value = false;
    selectedBudget.value = null;
};

const submitBudget = () => {
    budgetForm.post(
        route("budget.store"),
        {},
        {
            onSuccess: () => {},
            onError: (errors) => console.log(errors),
        }
    );
};

const handleUpdateStatus = (id) => {
    router.patch(route("budget.activate", id), {
        onSuccess: () => {
            console.log("Success");
        },
        onError: (e) => {
            console.log("Error", e);
        },
    });
};
const handleDeleteBudget = (id) => {
    router.delete(
        route("budget.destroy", id),

        {
            onSuccess: () => {
                console.log("Success");
            },
            onError: (e) => {
                console.log("Error", e);
            },
        }
    );
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="flex gap-4">
            <Section class="w-1/2">
                <Label size="lg"> Current Active Budget </Label>
                <TextInput
                    :model-value="props.activeBudget?.source"
                    :disable="true"
                    class="mt-1 block w-full"
                />

                <ul
                    class="list-disc pl-5 text-sm text-gray-500 mt-6"
                    role="list"
                    aria-label="Current budget status notes"
                >
                    <li>
                        <strong class="text-amber-600">Current budget:</strong>
                        The active budget is used for all new expenses until it
                        is deactivated or another budget is activated.
                    </li>
                    <li>
                        <strong class="text-amber-600"
                            >Deactivate / Activate:</strong
                        >
                        Deactivating the current budget stops new charges from
                        using it; activate a different budget to make it the
                        default for future expenses.
                    </li>
                    <li>
                        <strong class="text-amber-600"
                            >One active budget:</strong
                        >
                        Only one budget can be active at a time — switching the
                        active budget does not change past expenses, only where
                        new expenses are recorded.
                    </li>
                </ul>
            </Section>

            <Section class="w-1/2">
                <Label size="lg">Create New Budget</Label>
                <form @submit.prevent="submitBudget" class="space-y-4">
                    <div>
                        <Label size="sm" for="source" class="mt-2"
                            >Budget Name</Label
                        >
                        <TextInput
                            id="source"
                            v-model="budgetForm.source"
                            type="text"
                            placeholder="Enter budget name"
                            class="mt-1 block w-full"
                        />
                    </div>

                    <div>
                        <Label size="sm" for="amount_limit" class="mt-2"
                            >Amount</Label
                        >
                        <TextInput
                            id="amount_limit"
                            v-model="budgetForm.amount_limit"
                            type="number"
                            placeholder="Enter budget amount"
                            class="mt-1 block w-full"
                        />
                    </div>

                    <Button type="submit"> Create Budget </Button>
                </form>
            </Section>
        </div>

        <!-- Budgets Table -->
        <Section class="mt-4">
            <Label size="lg">All Budgets</Label>
            <div class="overflow-x-auto mt-2">
                <Table
                    :headers="[
                        'ID',
                        'AMOUNT',
                        'STATUS',
                        'SOURCE',
                        'DATE',
                        'ACTIONS',
                    ]"
                >
                    <tr
                        class="border-b hover:bg-gray-50 dark:hover:text-gray-700"
                        v-for="budget in props.budgets"
                    >
                        <td class="px-6 py-4 text-sm">{{ budget.id }}</td>
                        <td class="px-6 py-4 text-sm">
                            {{ $page.props.auth.user.currency }}
                            {{ formatAmount(budget.amount_limit ?? 0) }}
                        </td>
                        <td class="px-6 py-4 text-sm">{{ budget.source }}</td>

                        <td
                            class="px-6 py-4 text-sm font-semibold"
                            :class="
                                budget.is_active
                                    ? 'text-amber-600 '
                                    : 'text-gray-500'
                            "
                        >
                            {{ budget.is_active ? "Active" : "Inactive" }}
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold">
                            {{ dayjs(budget.created_at).format("MMM D, YYYY") }}
                        </td>

                        <td class="px-6 py-4 text-sm space-x-2">
                            <Button
                                type="button"
                                @clicked="openEditBudgetModal(budget)"
                            >
                                Edit
                            </Button>
                            <Button
                                type="button"
                                variant="danger"
                                :disabled="!!budget.is_active"
                                @clicked="handleDeleteBudget(budget.id)"
                            >
                                Delete</Button
                            >
                            <Button
                                type="button"
                                variant="secondary"
                                :disabled="!!budget.is_active"
                                @clicked="handleUpdateStatus(budget.id)"
                                >Activate</Button
                            >
                        </td>
                    </tr>
                </Table>
            </div>
        </Section>

        <Modal :show="showModal" @close="closeEditBudgetModal">
            <template v-if="selectedBudget">
                <form
                    @submit.prevent="
                        editBudgetForm.put(
                            route('budget.update', selectedBudget.id),
                            {
                                onSuccess: () => {
                                    closeEditBudgetModal();
                                },
                            }
                        )
                    "
                    class="space-y-4"
                >
                    <div class="p-6">
                        <div>
                            <Label size="sm" for="source" class="mt-3"
                                >Budget Name</Label
                            >
                            <TextInput
                                id="source"
                                type="text"
                                v-model="editBudgetForm.source"
                                placeholder="Enter budget name"
                                class="mt-1 block w-full"
                            />
                        </div>

                        <div>
                            <Label size="sm" for="amount_limit" class="mt-3"
                                >Amount</Label
                            >
                            <TextInput
                                id="amount_limit"
                                v-model="editBudgetForm.amount_limit"
                                type="number"
                                placeholder="Enter budget amount"
                                class="mt-1 block w-full"
                            />
                        </div>

                        <div class="mt-6 flex justify-end gap-2">
                            <Button
                                type="button"
                                variant="secondary"
                                @click="closeEditBudgetModal"
                            >
                                Cancel
                            </Button>
                            <Button type="submit"> Edit Budget </Button>
                        </div>
                    </div>
                </form>
            </template>
        </Modal>
    </AuthenticatedLayout>
</template>
