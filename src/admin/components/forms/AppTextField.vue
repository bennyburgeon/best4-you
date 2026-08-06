<script setup>
const props = defineProps({
  modelValue: [String, Number],
  label: String,
  type: {
    type: String,
    default: 'text'
  },
  placeholder: String,
  required: Boolean,
  errorMessages: [String, Array],
  rules: Array,
  disabled: Boolean,
  readonly: Boolean,
  prefix: String,
  suffix: String,
  prependIcon: String,
  appendIcon: String,
  prependInnerIcon: String,
  appendInnerIcon: String,
  clearable: {
    type: Boolean,
    default: true
  }
})

const emit = defineEmits(['update:modelValue'])

const onInput = (val) => emit('update:modelValue', val)
</script>

<template>
  <VTextField
    :model-value="props.modelValue"
    :label="props.label"
    :type="props.type"
    :placeholder="props.placeholder"
    :required="props.required"
    :error-messages="props.errorMessages"
    :rules="props.rules"
    :disabled="props.disabled"
    :readonly="props.readonly"
    :prefix="props.prefix"
    :suffix="props.suffix"
    :prepend-icon="props.prependIcon"
    :append-icon="props.appendIcon"
    :prepend-inner-icon="props.prependInnerIcon"
    :append-inner-icon="props.appendInnerIcon"
    :clearable="props.clearable"
    @update:model-value="onInput"
    variant="outlined"
    density="comfortable"
  />
</template>
