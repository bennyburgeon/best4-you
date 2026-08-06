<script setup>
import { computed } from 'vue'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'

const props = defineProps({
  modelValue: String,
  label: String,
  height: {
    type: Number,
    default: 300
  }
})

const emit = defineEmits(['update:modelValue'])

const content = computed({
  get: () => props.modelValue || '',
  set: (val) => emit('update:modelValue', val)
})
</script>

<template>
  <div class="quill-editor-wrapper">
    <VLabel v-if="props.label" class="mb-2 d-block font-weight-medium">{{ props.label }}</VLabel>
    <div class="editor-container border rounded">
      <QuillEditor 
        v-model:content="content" 
        contentType="html" 
        theme="snow" 
        toolbar="essential"
      />
    </div>
  </div>
</template>

<style scoped>
.quill-editor-wrapper {
  margin-bottom: 20px;
}
.editor-container {
  background: rgb(var(--v-theme-surface));
  border-color: rgba(var(--v-border-color), var(--v-border-opacity)) !important;
}
:deep(.ql-editor) {
  min-height: v-bind('props.height + "px"');
  font-family: inherit;
  font-size: 14px;
}
:deep(.ql-toolbar.ql-snow) {
  border-top: none;
  border-left: none;
  border-right: none;
  background-color: rgb(var(--v-theme-surface));
  border-bottom: 1px solid rgba(var(--v-border-color), var(--v-border-opacity));
}
:deep(.ql-container.ql-snow) {
  border: none;
}
</style>


