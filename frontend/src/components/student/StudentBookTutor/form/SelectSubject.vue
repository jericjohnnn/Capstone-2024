<template>
<div>
  <label class="block text-sm font-medium text-gray-700 mb-1">Select subject:</label>
  <select
    v-model="selectedSubject"
    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
  >
    <option value="">Select Subject</option>
    <option
      v-for="subject in tutor.subjects"
      :key="subject.id"
      :value="subject.name"
    >
      {{ subject.name }}
    </option>
  </select>
</div>
</template>

<script setup>
import { ref, watch } from 'vue'

defineProps({
  tutor: {
    type: Object,
    required: true
  }
})

const selectedSubject = ref('')

const emit = defineEmits(['update:selectedSubject'])

watch(selectedSubject, (newVal) => {
  emit('update:selectedSubject', newVal)
})
</script>

