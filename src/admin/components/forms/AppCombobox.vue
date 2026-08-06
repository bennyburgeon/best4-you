<script setup>
const props = defineProps({
  modelValue: [String, Number, Array, Object],
  label: String,
  items: Array,
  multiple: {
    type: Boolean,
    default: false
  },
  chips: {
    type: Boolean,
    default: true
  },
  clearable: {
    type: Boolean,
    default: true
  },
  placeholder: String,
  rules: Array,
  disabled: Boolean,
  loading: Boolean
})

const emit = defineEmits(['update:modelValue'])

const onUpdate = (val) => emit('update:modelValue', val)
</script>

<template>
  <VCombobox
    :model-value="props.modelValue"
    :label="props.label"
    :items="props.items"
    :multiple="props.multiple"
    :chips="props.chips"
    :clearable="props.clearable"
    :placeholder="props.placeholder"
    :rules="props.rules"
    :disabled="props.disabled"
    :loading="props.loading"
    @update:model-value="onUpdate"
    variant="outlined"
    density="comfortable"
  />
</template>
