<template>
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1"
      >Contact number:</label
    >
    <div class="flex gap-2">
      <input
        v-model="contactNumber"
        type="text"
        :readonly="isReadonly"
        class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
      />
      <button
        type="button"
        @click="toggleEditing"
        class="px-3 py-1 text-sm text-blue-600 hover:text-blue-700"
      >
        {{ isReadonly ? 'Change number' : 'Apply' }}
      </button>
      <button
        v-if="!isReadonly"
        type="button"
        @click="cancelChanges"
        class="px-3 py-1 text-sm text-gray-600 hover:text-gray-700"
      >
        Cancel
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  contactNumber: {
    type: String,
    required: true
  }
})

const modifiedContactNumber = ref('')

const isReadonly = ref(true)

const toggleEditing = () => {
  isReadonly.value = !isReadonly.value
  modifiedContactNumber.value = contactNumber.value
}

const cancelChanges = () => {
  contactNumber.value = modifiedContactNumber.value
  isReadonly.value = true
}

const contactNumber = ref(props.contactNumber)

const emit = defineEmits(['update:contactNumber'])

watch(contactNumber, (newVal) => {
  emit('update:contactNumber', newVal)
})
</script>
