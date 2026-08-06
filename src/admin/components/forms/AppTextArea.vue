<script setup>
const props = defineProps({
  modelValue: String,
  label: String,
  rows: {
    type: [String, Number],
    default: 5
  },
  placeholder: String,
  required: Boolean,
  rules: Array,
  disabled: Boolean,
  readonly: Boolean,
  clearable: {
    type: Boolean,
    default: true
  }
})

const emit = defineEmits(['update:modelValue'])

const onInput = (val) => emit('update:modelValue', val)
</script>

<template>
  <VTextarea
    :model-value="props.modelValue"
    :label="props.label"
    :rows="props.rows"
    :placeholder="props.placeholder"
    :required="props.required"
    :rules="props.rules"
    :disabled="props.disabled"
    :readonly="props.readonly"
    :clearable="props.clearable"
    @update:model-value="onInput"
    variant="outlined"
    density="comfortable"
    auto-grow
  />
</template>
