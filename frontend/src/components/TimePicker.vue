<template>
  <div class="py-2">
    <div class="flex gap-4">
      <div class="mb-4 flex items-center gap-1">
        <label class="">Start:</label>
        <select v-model="startHour" class="border px-12 rounded">
          <option v-for="hour in 12" :key="hour" :value="hour">
            {{ String(hour).padStart(2, '0') }}
          </option>
        </select>
        <span>:</span>
        <select v-model="startMinute" class="border px-12 rounded">
          <option value="00">00</option>
          <option value="30">30</option>
        </select>
        <select v-model="startPeriod" class="border px-12 rounded">
          <option value="AM">AM</option>
          <option value="PM">PM</option>
        </select>
      </div>

      <div class="mb-6 flex items-center gap-1">
        <label class="">End:</label>
        <select v-model="endHour" class="border px-12 rounded">
          <option v-for="hour in 12" :key="hour" :value="hour">
            {{ String(hour).padStart(2, '0') }}
          </option>
        </select>
        <span>:</span>
        <select v-model="endMinute" class="border px-12 rounded">
          <option value="00">00</option>
          <option value="30">30</option>
        </select>
        <select v-model="endPeriod" class="border px-12 rounded">
          <option value="AM">AM</option>
          <option value="PM">PM</option>
        </select>
      </div>
    </div>
    <button
      @click="addTime"
      class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition-colors"
      :disabled="isDisabled"
    >
      {{ isDisabled ? 'Select a date' : 'Add time' }}
    </button>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { convertTo24Hour } from '@/utils/dateTime'

const emit = defineEmits([
  'update:start-time',
  'update:end-time',
  'triggerTimeUpdate',
])

defineProps({
  isDisabled: {
    type: Boolean,
    required: false,
    default: false,
  },
})

const startHour = ref(9)
const startMinute = ref('00')
const startPeriod = ref('AM')

const endHour = ref(10)
const endMinute = ref('00')
const endPeriod = ref('AM')

const addTime = () => {
  const startTime = convertTo24Hour(
    startHour.value,
    startMinute.value,
    startPeriod.value,
  )
  const endTime = convertTo24Hour(
    endHour.value,
    endMinute.value,
    endPeriod.value,
  )
  emit('update:start-time', startTime)
  emit('update:end-time', endTime)
  emit('triggerTimeUpdate')
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
