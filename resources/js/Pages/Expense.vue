<script setup>
import TextInput from "@/Components/TextInput.vue";
import Textarea from "@/Components/Textarea.vue";
import Select from "@/Components/Select.vue";
import Button from "@/Components/Button.vue";
import Table from "@/Components/Table.vue";
import Label from "@/Components/Label.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    data: Object,
    categories: Array,
});

const form = useForm({
    amount: "",
    category_id: "",
    expenses_date: "",
    description: "",
});

const submit = () => {
    const formattedDate = form.expenses_date.replace(/\//g, "-");
    form.expenses_date = formattedDate;

    form.post(route("expense.store"), {
        onSuccess: () => form.reset(),
        onError: (errors) => console.log(errors),
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="">
            <div class="flex gap-4">
                <form
                    @submit.prevent="submit"
                    class="w-2/5 flex flex-col gap-4"
                >
                    <div class="">
                        <Label size="lg" for="amount">Amount</Label>
                        <TextInput
                            id="amount"
                            type="number"
                            step="0.01"
                            min="0"
                            class="mt-1 block w-full"
                            required
                            v-model="form.amount"
                        />
                    </div>
                    <div class="">
                        <Label size="lg" for="category">Category</Label>
                        <Select
                            id="category"
                            v-model="form.category_id"
                            :options="
                                props.categories?.map((category) => ({
                                    value: category.id,
                                    label: category.name,
                                }))
                            "
                            placeholder="Select category"
                            :required="true"
                        />
                    </div>
                    <div class="">
                        <Label size="lg" for="date">Date</Label>
                        <TextInput
                            id="date"
                            type="date"
                            class="mt-1 block w-full"
                            required
                            v-model="form.expenses_date"
                        />
                    </div>
                    <div class="">
                        <Label size="lg" for="description">Description</Label>
                        <Textarea
                            id="description"
                            rows="4"
                            v-model="form.description"
                            maxlength="50"
                        />
                    </div>
                    <Button
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        type="submit"
                    >
                        Submit
                    </Button>
                </form>

                <div class="w-3/5">
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
                            class="border-b hover:bg-gray-50"
                            v-for="expense in props.data?.expenses"
                        >
                            <td class="px-4 py-3">{{ expense.id }}</td>
                            <td class="px-4 py-3">
                                {{ expense?.category.name }}
                            </td>
                            <td class="px-4 py-3">{{ expense.amount }}</td>
                            <td class="px-4 py-3">{{ expense.description }}</td>
                            <td class="px-4 py-3">
                                {{ expense.expenses_date }}
                            </td>
                        </tr>
                    </Table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
