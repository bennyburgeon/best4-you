<script setup>
import { onMounted, onUnmounted, ref, watch } from 'vue'
import Dropzone from 'dropzone'
import 'dropzone/dist/dropzone.css'

const props = defineProps({
  modelValue: [File, Array, String],
  label: {
    type: String,
    default: 'Drop files here or click to upload'
  },
  multiple: {
    type: Boolean,
    default: false
  },
  acceptedFiles: {
    type: String,
    default: 'image/*,application/pdf,.doc,.docx'
  },
  maxFiles: {
    type: Number,
    default: null
  }
})

const emit = defineEmits(['update:modelValue', 'change'])

const dropzoneRef = ref(null)
let dz = null

onMounted(() => {
  dz = new Dropzone(dropzoneRef.value, {
    url: '/', // Dummy URL since we handle files manually
    autoProcessQueue: false,
    addRemoveLinks: true,
    uploadMultiple: props.multiple,
    maxFiles: props.multiple ? props.maxFiles : 1,
    acceptedFiles: props.acceptedFiles,
    dictDefaultMessage: props.label
  })

  dz.on('addedfile', (file) => {
    if (!props.multiple && dz.files.length > 1) {
      dz.removeFile(dz.files[0])
    }
    
    if (props.multiple) {
      emit('update:modelValue', dz.files)
      emit('change', dz.files)
    } else {
      emit('update:modelValue', file)
      emit('change', file)
    }
  })

  dz.on('removedfile', (file) => {
    if (props.multiple) {
      emit('update:modelValue', dz.files)
      emit('change', dz.files)
    } else {
      emit('update:modelValue', null)
      emit('change', null)
    }
  })
})

onUnmounted(() => {
  if (dz) dz.destroy()
})
</script>

<template>
  <div class="dropzone-wrapper mb-4">
    <VLabel v-if="props.label" class="mb-2 d-block font-weight-medium">{{ props.label }}</VLabel>
    <div ref="dropzoneRef" class="dropzone custom-dropzone">
      <div class="dz-message" data-dz-message>
        <VIcon icon="bx-cloud-upload" size="48" color="primary" class="mb-2" />
        <div class="text-subtitle-1">Drop files here or click to upload</div>
        <div class="text-caption text-secondary">Accepted files: {{ props.acceptedFiles }}</div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.custom-dropzone {
  border: 2px dashed rgba(var(--v-border-color), 0.5);
  border-radius: 8px;
  background: transparent;
  min-height: 150px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  transition: border-color 0.3s ease;
}

.custom-dropzone:hover {
  border-color: rgb(var(--v-theme-primary));
}

.dz-message {
  text-align: center;
}
</style>
