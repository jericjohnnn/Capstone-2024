<template>
  <div class="mb-6">
    <h3 class="font-medium mb-2">
      Hours available:
      <button @click="toggleEdit" class="ml-2 text-blue-600">
        {{ isEditing ? 'Cancel' : 'Edit' }}
      </button>
    </h3>

    <div v-if="!isEditing">
      <p class="text-blue-600 font-medium">
        {{ formatTo12Hour(userData.work_days.start_time) }} - {{ formatTo12Hour(userData.work_days.end_time) }}
      </p>
    </div>

    <div v-else class="space-y-2">
      <div class="flex gap-2">
        <select v-model="startTime.hour" class="border p-1 rounded">
          <option v-for="h in 12" :key="h" :value="h">{{ h }}</option>
        </select>
        <select v-model="startTime.period" class="border p-1 rounded">
          <option value="AM">AM</option>
          <option value="PM">PM</option>
        </select>
      </div>

      <div class="flex gap-2">
        <select v-model="endTime.hour" class="border p-1 rounded">
          <option v-for="h in 12" :key="h" :value="h">{{ h }}</option>
        </select>
        <select v-model="endTime.period" class="border p-1 rounded">
          <option value="AM">AM</option>
          <option value="PM">PM</option>
        </select>
      </div>

      <button @click="saveHours" class="text-blue-600">Save</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axiosInstance from '@/axiosInstance'

// State management
const isEditing = ref(false)
const userData = JSON.parse(localStorage.getItem('user_data') || '{}')
const startTime = ref(parseTo12Hour(userData.work_days?.start_time || '06:00:00'))
const endTime = ref(parseTo12Hour(userData.work_days?.end_time || '20:00:00'))

// Helper functions
function parseTo12Hour(time24h) {
  const [hours] = time24h.split(':')
  const hour = parseInt(hours, 10)
  return { hour: hour % 12 || 12, period: hour >= 12 ? 'PM' : 'AM' }
}

function formatTo12Hour(time24h) {
  const { hour, period } = parseTo12Hour(time24h)
  const minutes = time24h.split(':')[1]
  return `${hour}:${minutes} ${period}`
}

function convertTo24Hour({ hour, period }) {
  if (period === 'PM' && hour !== 12) hour += 12
  if (period === 'AM' && hour === 12) hour = 0
  return `${String(hour).padStart(2, '0')}:00:00`
}

// Save hours function
async function saveHours() {
  const start24 = convertTo24Hour(startTime.value)
  const end24 = convertTo24Hour(endTime.value)

  userData.work_days = { start_time: start24, end_time: end24 }
  localStorage.setItem('user_data', JSON.stringify(userData))

  try {
    await axiosInstance.put('/api/edit-work-days', { start_time: start24, end_time: end24 })
    isEditing.value = false
  } catch (error) {
    console.error('Error saving hours:', error)
  }
}

function toggleEdit() {
  isEditing.value = !isEditing.value
}
</script>
