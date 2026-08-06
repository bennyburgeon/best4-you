<script setup>
const props = defineProps({
  modelValue: [String, Number, Array, Object],
  label: String,
  items: Array,
  itemTitle: {
    type: String,
    default: 'title'
  },
  itemValue: {
    type: String,
    default: 'value'
  },
  multiple: Boolean,
  chips: Boolean,
  clearable: {
    type: Boolean,
    default: true
  },
  disabled: Boolean,
  loading: Boolean,
  placeholder: String,
  rules: Array,
  closableChips: {
    type: Boolean,
    default: true
  }
})

const emit = defineEmits(['update:modelValue'])

const onUpdate = (val) => emit('update:modelValue', val)
</script>

<template>
  <VAutocomplete
    :model-value="props.modelValue"
    :label="props.label"
    :items="props.items"
    :item-title="props.itemTitle"
    :item-value="props.itemValue"
    :multiple="props.multiple"
    :chips="props.chips"
    :clearable="props.clearable"
    :disabled="props.disabled"
    :loading="props.loading"
    :placeholder="props.placeholder"
    :rules="props.rules"
    :closable-chips="props.closableChips"
    @update:model-value="onUpdate"
    variant="outlined"
    density="comfortable"
    autocomplete="off"
  />
</template>
