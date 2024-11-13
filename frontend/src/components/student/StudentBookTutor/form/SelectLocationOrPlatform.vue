<template>
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
      {{
        learningPreference === 'Online'
          ? 'Video Platform:'
          : 'Location:'
      }}
    </label>
    <select
      v-if="learningPreference === 'Online'"
      v-model="videoPlatform"
      class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
    >
      <option value="Zoom">Zoom</option>
      <option value="Google Meet">Google Meet</option>
      <option value="Skype">Skype</option>
    </select>
    <input
      v-else-if="learningPreference === 'Face to Face'"
      v-model="location"
      type="text"
      placeholder="Enter location"
      class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
    />
    <div v-else class="w-full p-2 bg-gray-50 rounded-md text-gray-700">
      {{ inSchoolAddress }}
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

defineProps({
  learningPreference: {
    type: String,
    required: true
  },
  inSchoolAddress: {
    type: String,
    required: true
  }
})

const videoPlatform = ref('')
const location = ref('')

const emit = defineEmits(['update:videoPlatform', 'update:location'])

watch(videoPlatform, (newVal) => {
  emit('update:videoPlatform', newVal)
})

watch(location, (newVal) => {
  emit('update:location', newVal)
})
</script>
