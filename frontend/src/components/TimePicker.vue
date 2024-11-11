<template>
  <div class="p-4">
    <div class="flex">
      <div class="mb-4 flex items-center gap-2">
        <label class="">Start:</label>
        <select v-model="startHour" class="border px-8 rounded">
          <option v-for="hour in 12" :key="hour" :value="hour">
            {{ String(hour).padStart(2, '0') }}
          </option>
        </select>
        <span>:</span>
        <select v-model="startMinute" class="border px-8 rounded">
          <option value="00">00</option>
          <option value="30">30</option>
        </select>
        <select v-model="startPeriod" class="border px-8 rounded">
          <option value="AM">AM</option>
          <option value="PM">PM</option>
        </select>
      </div>

      <div class="mb-6 flex items-center gap-2">
        <label class="">End:</label>
        <select v-model="endHour" class="border px-8 rounded">
          <option v-for="hour in 12" :key="hour" :value="hour">
            {{ String(hour).padStart(2, '0') }}
          </option>
        </select>
        <span>:</span>
        <select v-model="endMinute" class="border px-8 rounded">
          <option value="00">00</option>
          <option value="30">30</option>
        </select>
        <select v-model="endPeriod" class="border px-8 rounded">
          <option value="AM">AM</option>
          <option value="PM">PM</option>
        </select>
      </div>
    </div>
    <button
      @click="addTime"
      class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition-colors"
      :disabled="isDay"
    >
      Add
    </button>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const emit = defineEmits(['update:start-time', 'update:end-time'])

defineProps({
  isDay: {
    type: Boolean,
    required: false,
    default: false,
  },
})

// Initialize time picker values
const startHour = ref(9)
const startMinute = ref('00')
const startPeriod = ref('AM')

const endHour = ref(10)
const endMinute = ref('00')
const endPeriod = ref('AM')

// Convert to 24-hour format
const convertTo24HourFormat = (hour, minute, period) => {
  let hours = hour
  if (period === 'PM' && hours < 12) hours += 12
  if (period === 'AM' && hours === 12) hours = 0
  return `${String(hours).padStart(2, '0')}:${minute}:00`
}

const addTime = () => {
  const startTime = convertTo24HourFormat(
    startHour.value,
    startMinute.value,
    startPeriod.value,
  )
  const endTime = convertTo24HourFormat(
    endHour.value,
    endMinute.value,
    endPeriod.value,
  )

  emit('update:start-time', startTime)
  emit('update:end-time', endTime)
}
</script>

<style scoped>
button {
  display: inline-block;
  width: 100%;
  background-color: #3182ce;
  color: white;
  padding: 0.5rem;
  border-radius: 0.375rem;
  text-align: center;
  cursor: pointer;
}

button:hover {
  background-color: #2b6cb0;
}

select {
  padding: 0.5rem;
  border-radius: 0.375rem;
  border: 1px solid #e2e8f0;
}

select:focus {
  outline: none;
  border-color: #3182ce;
}

button:disabled {
  background-color: #d3d3d3;
  color: #888888;
  cursor: not-allowed;
  opacity: 0.6;
  pointer-events: none;
}

button:disabled:hover {
  background-color: #d3d3d3;
  color: #888888;
}
</style>
