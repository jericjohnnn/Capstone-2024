<template>
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Message:</label>
    <div class="border border-gray-300 rounded-md overflow-hidden">
      <input
        v-model="topic"
        placeholder="Enter the topic that needs tutoring"
        class="w-full border-b border-gray-300 p-3 focus:outline-none focus:ring-0 focus:border-blue-500"
      />
      <textarea
        v-model="message"
        placeholder="Enter objectives, concerns, and further details of your inquiry"
        class="w-full p-3 h-32 resize-none focus:outline-none focus:ring-0 focus:border-blue-500"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const topic = ref('')
const message = ref('')

const emit = defineEmits(['update:tutorTopic', 'update:tutorMessage'])

watch(topic, (newVal) => {
  emit('update:tutorTopic', newVal)
})

watch(message, (newVal) => {
  emit('update:tutorMessage', newVal)
})
</script>
