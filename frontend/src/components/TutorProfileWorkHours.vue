<template>
  <div class="mb-6">
    <h3 class="font-medium mb-2">
      Hours available:
      <button @click="isEditing = !isEditing" class="ml-2 text-blue-600">
        {{ isEditing ? 'Cancel' : 'Edit' }}
      </button>
    </h3>

    <div v-if="!isEditing">
      <p class="text-blue-600 font-medium">{{ displayStartTime }} - {{ displayEndTime }}</p>
    </div>

    <div v-else class="space-y-2">
      <!-- Start Time -->
      <div class="flex gap-2">
        <select v-model="startTime.hour" class="border p-1 rounded">
          <option v-for="h in 12" :key="h" :value="h">{{ h }}</option>
        </select>
        <select v-model="startTime.minute" class="border p-1 rounded">
          <option value="00">00</option>
          <option value="30">30</option>
        </select>
        <select v-model="startTime.period" class="border p-1 rounded">
          <option value="AM">AM</option>
          <option value="PM">PM</option>
        </select>
      </div>

      <!-- End Time -->
      <div class="flex gap-2">
        <select v-model="endTime.hour" class="border p-1 rounded">
          <option v-for="h in 12" :key="h" :value="h">{{ h }}</option>
        </select>
        <select v-model="endTime.minute" class="border p-1 rounded">
          <option value="00">00</option>
          <option value="30">30</option>
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
import { ref, computed } from 'vue'
import axiosInstance from '@/axiosInstance'

const isEditing = ref(false)

// Get initial values from localStorage
const userData = JSON.parse(localStorage.getItem('user_data') || '{}')
const initialStartTime = userData?.work_days?.start_time || '09:00:00'
const initialEndTime = userData?.work_days?.end_time || '17:00:00'

// Convert 24h to 12h format for initial values
function parse24hTo12h(time24h) {
  const [hours, minutes] = time24h.split(':')
  const hour = parseInt(hours)
  return {
    hour: hour % 12 || 12,
    minute: minutes,
    period: hour >= 12 ? 'PM' : 'AM'
  }
}

const startTime = ref(parse24hTo12h(initialStartTime))
const endTime = ref(parse24hTo12h(initialEndTime))

// Display computed properties
const displayStartTime = computed(() =>
  `${startTime.value.hour}:${startTime.value.minute} ${startTime.value.period}`
)
const displayEndTime = computed(() =>
  `${endTime.value.hour}:${endTime.value.minute} ${endTime.value.period}`
)

// Convert 12h to 24h format for saving
function convertTo24Hour(time12h) {
  let hour = time12h.hour
  if (time12h.period === 'PM' && hour !== 12) hour += 12
  if (time12h.period === 'AM' && hour === 12) hour = 0
  return `${hour.toString().padStart(2, '0')}:${time12h.minute}:00`
}

async function saveHours() {
  const start24 = convertTo24Hour(startTime.value)
  const end24 = convertTo24Hour(endTime.value)

  // Update localStorage
  userData.work_days = {
    ...userData.work_days,
    start_time: start24,
    end_time: end24
  }
  localStorage.setItem('user_data', JSON.stringify(userData))

  // Send to API
  try {
    await axiosInstance.put('/api/edit-work-days', {
      start_time: start24,
      end_time: end24
    })
    isEditing.value = false
  } catch (error) {
    console.error('Error saving hours:', error)
  }
}
</script>
