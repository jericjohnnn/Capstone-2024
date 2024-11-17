<template>
  <div class="mb-6">
    <div class="flex justify-between items-center mb-3">
      <h3 class="font-medium">Hours available</h3>
      <button 
        @click="toggleEdit" 
        class="text-blue-600 text-sm hover:text-blue-700 transition-colors"
      >
        {{ isEditing ? 'Cancel' : 'Edit' }}
      </button>
    </div>

    <!-- Display Mode -->
    <div v-if="!isEditing" class="px-2">
      <p class="text-blue-600 text-sm font-medium">
        {{ formatTo12Hour(userData.work_days.start_time) }} - {{ formatTo12Hour(userData.work_days.end_time) }}
      </p>
    </div>

    <!-- Edit Mode -->
    <div v-else class="space-y-3">
      <div class="flex flex-col sm:flex-row gap-3">
        <!-- Start Time -->
        <div class="flex-1 space-y-1">
          <label class="text-sm text-gray-600">Start Time</label>
          <div class="flex gap-2">
            <select 
              v-model="startTime.hour" 
              class="flex-1 px-3 py-1.5 border rounded text-sm focus:border-blue-500 focus:outline-none"
            >
              <option v-for="h in 12" :key="h" :value="h">{{ h }}</option>
            </select>
            <select 
              v-model="startTime.period" 
              class="w-20 px-3 py-1.5 border rounded text-sm focus:border-blue-500 focus:outline-none"
            >
              <option value="AM">AM</option>
              <option value="PM">PM</option>
            </select>
          </div>
        </div>

        <!-- End Time -->
        <div class="flex-1 space-y-1">
          <label class="text-sm text-gray-600">End Time</label>
          <div class="flex gap-2">
            <select 
              v-model="endTime.hour" 
              class="flex-1 px-3 py-1.5 border rounded text-sm focus:border-blue-500 focus:outline-none"
            >
              <option v-for="h in 12" :key="h" :value="h">{{ h }}</option>
            </select>
            <select 
              v-model="endTime.period" 
              class="w-20 px-3 py-1.5 border rounded text-sm focus:border-blue-500 focus:outline-none"
            >
              <option value="AM">AM</option>
              <option value="PM">PM</option>
            </select>
          </div>
        </div>
      </div>

      <div class="flex justify-end pt-2">
        <button
          @click="saveHours"
          class="w-full sm:w-auto px-6 py-1.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors"
        >
          Save
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axiosInstance from '@/axiosInstance'
import { parseTo12Hour, convertTo24Hour, formatTo12Hour } from '@/utils/dateTime'
import { getUserData } from '@/utils/user'

// State management
const isEditing = ref(false)
const userData = getUserData()
const startTime = ref(parseTo12Hour(userData.work_days?.start_time || '06:00:00'))
const endTime = ref(parseTo12Hour(userData.work_days?.end_time || '20:00:00'))

// Save hours function
async function saveHours() {
  const start24 = convertTo24Hour(startTime.value)
  const end24 = convertTo24Hour(endTime.value)

  userData.value.work_days = { start_time: start24, end_time: end24 }
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
