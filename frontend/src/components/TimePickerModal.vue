<template>
  <div>
    <div
      v-if="isModalOpen"
      class="fixed z-50 inset-0 bg-black bg-opacity-50 flex items-center justify-center"
    >
      <div class="bg-white p-4 rounded-lg w-96" @click.stop>
        <div class="flex justify-between items-center mb-4">
          <div class="flex flex-col">
            <h2 class="text-lg font-semibold">Select Time</h2>
            <div v-if="selectedDate">
              <p>{{ formatDate(selectedDate) }}</p>
            </div>
          </div>
          <button
            @click="closeModal"
            class="text-gray-500 hover:text-gray-700 text-2xl"
          >
            &times;
          </button>
        </div>

        <!-- Start Time -->
        <div class="mb-4 flex items-center gap-2">
          <label class="w-20">Start Time:</label>
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

        <!-- End Time -->
        <div class="mb-6 flex items-center gap-2">
          <label class="w-20">End Time:</label>
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

        <button
          @click="confirmTimes"
          class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition-colors"
        >
          Confirm
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { formatDate, convertTo24Hour } from '@/utils/dateTime'


defineProps({
  isModalOpen: {
    type: Boolean,
    required: true,
  },
  selectedDate: {
    type: String,
    required: false,
    default: '',
  },
})

const emit = defineEmits(['update:start-time', 'update:end-time', 'close'])
// Initialize time picker values
const startHour = ref(9)
const startMinute = ref('00')
const startPeriod = ref('AM')

const endHour = ref(10)
const endMinute = ref('00')
const endPeriod = ref('AM')

const confirmTimes = () => {
  const startTime = convertTo24Hour(
    startHour.value,
    startMinute.value,
    startPeriod.value
  )
  const endTime = convertTo24Hour(
    endHour.value,
    endMinute.value,
    endPeriod.value
  )

  emit('update:start-time', startTime)
  emit('update:end-time', endTime)
  closeModal()
}

const closeModal = () => {
  startHour.value = 9
  startMinute.value = '00'
  startPeriod.value = 'AM'
  endHour.value = 10
  endMinute.value = '00'
  endPeriod.value = 'AM'

  emit('close')
}
</script>
