<template>
  <div>
    <p>Selected dates:</p>
    <div
      v-if="dates.length === 0"
      class="outline flex justify-center items-center"
    >
      <p class="text-slate-400">No dates selected</p>
    </div>
    <div v-else class="flex flex-col items-center justify-center w-full">
      <div v-for="date in dates" :key="date.id" class="my-2">
        <div class="bg-blue-500 text-white inline-flex text-sm items-center rounded-full px-3 py-1">
          <span class="font-semibold mr-2">
            {{ formatDate(date.start) }}
          </span>
          <span class="mr-2">
            {{ formatTo12Hour(extractTimeFromDateTimeString(date.start)) }} to
            {{ formatTo12Hour(extractTimeFromDateTimeString(date.end)) }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {
  formatDate,
  formatTo12Hour,
  extractTimeFromDateTimeString,
} from '@/utils/dateTime'

const props = defineProps({
  dates: {
    type: Array,
    default: () => [],
  },
})
</script>
