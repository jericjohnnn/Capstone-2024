<template>
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1"
      >Learning preference:</label
    >
    <select
      v-model="learningPreference"
      class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
    >
      <option value="In School">In School</option>
      <option value="Online">Online</option>
      <option value="Face to Face">Face to Face</option>
    </select>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const learningPreference = ref('')

const emit = defineEmits(['update:learningPreference'])

watch(learningPreference, (newVal) => {
  emit('update:learningPreference', newVal)
})
</script>
