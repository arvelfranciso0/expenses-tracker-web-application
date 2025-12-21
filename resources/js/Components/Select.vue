<script setup>
import { ref, watch, defineEmits } from "vue";

const props = defineProps({
    id: { type: String, required: true },
    modelValue: { type: [String, Number], default: "" },
    placeholder: { type: String, default: "" },
    required: { type: Boolean, default: false },
    error: { type: String, default: "" },
    disabled: { type: Boolean, default: false },
});

const emit = defineEmits(["update:modelValue"]);

const localValue = ref(props.modelValue);

watch(
    () => props.modelValue,
    (val) => {
        localValue.value = val;
    }
);

function updateValue(value) {
    emit("update:modelValue", value);
}
</script>

<template>
    <div class="w-full">
        <select
            :id="id"
            v-model="localValue"
            @change="updateValue($event.target.value)"
            class="border border-gray-300 rounded-lg px-3 w-full py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700"
            :required="required"
            :disabled="disabled"
        >
            <option v-if="placeholder" disabled value="">
                {{ placeholder }}
            </option>

            <slot />
        </select>
        <p v-if="error" class="text-red-500 text-sm mt-1">{{ error }}</p>
    </div>
</template>
