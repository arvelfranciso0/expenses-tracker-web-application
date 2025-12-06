<script setup>
import StatCard from "@/Components/StatCard.vue";
import { Landmark, Banknote, PiggyBank, Plus } from "lucide-vue-next";
import Button from "@/Components/Button.vue";
import Table from "@/Components/Table.vue";
import Label from "@/Components/Label.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>

<template>
    <AuthenticatedLayout>
        <div class="contianer">
            <div class="flex flex-col gap-4">
                <div
                    class="flex flex-col md:flex-row items-center md:items-stretch gap-2 mb-4"
                >
                    <StatCard
                        label="Total Budget"
                        value="20000"
                        :icon="Landmark"
                        class="w-1/3"
                    />
                    <StatCard
                        label="Total Expenses"
                        value="20000"
                        :icon="Banknote"
                        class="w-1/3"
                    />
                    <StatCard
                        label="Total Yearly"
                        value="20000"
                        :icon="PiggyBank"
                        class="w-1/3"
                    />
                </div>

                <div class="mb-4 flex gap-2 justify-end">
                    <Button
                        :href="route('expense.index')"
                        class="inline-flex items-center gap-2"
                    >
                        <Plus /> Expenses
                    </Button>

                    <Button
                        :href="route('expense.index')"
                        variant="secondary"
                        class="inline-flex items-center gap-2"
                    >
                        <Plus /> Budgets
                    </Button>
                </div>

                <div class="flex gap-2">
                    <div class="w-2/3">
                        <Label size="lg">Budgets</Label>
                        <Table :headers="['ID', 'Amount Limit', 'Date']">
                            <tr
                                class="border-b hover:bg-gray-50 dark:hover:text-gray-700"
                            >
                                <td class="px-4 py-3">1</td>
                                <td class="px-4 py-3">10000</td>
                                <td class="px-4 py-3">12/2025</td>
                            </tr>
                        </Table>
                    </div>
                    <div class="w-2/3">
                        <Label size="lg">Expenses</Label>
                        <Table
                            :headers="[
                                'ID',
                                'Category',
                                'Amount',
                                'Description',
                                'Date',
                            ]"
                        >
                            <tr
                                class="border-b hover:bg-gray-50 dark:hover:text-gray-700"
                            >
                                <td class="px-4 py-3">1</td>
                                <td class="px-4 py-3">Loan</td>
                                <td class="px-4 py-3">10000</td>
                                <td class="px-4 py-3">Paying for the loan.</td>
                                <td class="px-4 py-3">12/6/2025</td>
                            </tr>
                        </Table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
