<template>
  <div>
    <vue-cal
      :click-to-navigate="isDay"
      v-model:active-view="activeView"
      active-view="month"
      :disable-views="['years', 'year', 'week']"
      :min-date="availableStartingDate"
      :hide-weekdays="hiddenWeekDays"
      :special-hours="specialHours"
      :time-from="0 * 60"
      :time-to="25 * 60"
      :events="events"
      @cell-click="storeCellDate"
      class="vuecal--full-height-delete w-96"
      style="height: calc(100vh - 300px)"
    >
      <template #title="{ view }">
        🎉
        <span class="" v-if="view.id === 'month'">{{
          view.startDate.format('MMMM YYYY')
        }}</span>
        <span class="" v-if="view.id === 'day'">{{
          view.endDate.format('dddd | MMMM D')
        }}</span>
        🎉
      </template>
      <template #event="{ event }">
        <div class="vuecal__event-title" v-html="event.title" />
        <span>{{ event.start.formatTime('hh:mm{am}') }}</span>
        <span>{{ event.end.formatTime('hh:mm{am}') }}</span>
      </template>
    </vue-cal>
    <div class="">
      <TimePicker
        :isDay="isDay"
        @update:start-time="updateStartTime"
        @update:end-time="updateEndTime"
      ></TimePicker>
      <div
        v-for="schedule in addedPendingSchedules"
        :key="schedule.id"
        class="mb-2"
      >
        <div class="bg-red-500 outline p-2 flex flex-col text-white">
          <button @click="deleteSchedule(schedule.id)">X</button>
          <div class="font-semibold">
            {{ new Date(schedule.start).format('MMMM-DD-YYYY') }}
          </div>
          <div>
            {{ new Date(schedule.start).formatTime('hh:mm{am}') }} to
            {{ new Date(schedule.end).formatTime('hh:mm{am}') }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import TimePicker from '../TimePicker.vue'
import { ref, computed, watch } from 'vue'
// import { useRouter } from 'vue-router'
// import axiosInstance from '@/axiosInstance'
import VueCal from 'vue-cal'
import 'vue-cal/dist/vuecal.css'

//HELPER FUNCTIONS!
function formatTimeToInteger(timeString) {
  if (!timeString) return null

  const [hours] = timeString.split(':')
  return parseInt(hours, 10)
}

const formatRawDateTime = dateString => {
  // Format to 'YYYY-MM-DD HH:mm:ss'
  return new Date(dateString).toISOString().slice(0, 19).replace('T', ' ')
}
//HELPER FUNCTIONS!

const emit = defineEmits(['selectedCellValue', 'pendingBookings', 'update:added-schedules'])

const props = defineProps({
  tutorBookings: {
    type: Array,
    default: () => [],
  },
  tutorWorkDays: {
    type: Object,
    default: () => {},
  },
  studentBookings: {
    type: Array,
    default: () => [],
  },
})

const events = ref([])

const clickedCellDate = ref()
const storeCellDate = event => {
  console.log(event)
  clickedCellDate.value = event
  emit('selectedCellValue', event)
}


//ADD NEW DATES
const selectedStartTime = ref('')
const selectedEndTime = ref('')

const updateStartTime = time => {
  selectedStartTime.value = time
}

const updateEndTime = time => {
  selectedEndTime.value = time
}

const addedPendingSchedules = ref([])

//
const isEventOverlap = (newStart, newEnd, event) => {
  const existingStartTime = new Date(event.start).getTime();
  const existingEndTime = new Date(event.end).getTime();

  // Check if the new slot overlaps with the existing slot
  return newStart < existingEndTime && newEnd > existingStartTime;
};

const addScheduleRequest = () => {
  const newStart = new Date(
    `${clickedCellDate.value.format('YYYY-MM-DD')} ${selectedStartTime.value}`
  ).getTime();
  const newEnd = new Date(
    `${clickedCellDate.value.format('YYYY-MM-DD')} ${selectedEndTime.value}`
  ).getTime();

  // Check for overlap in existing events
  const hasOverlap = events.value.some(event =>
    isEventOverlap(newStart, newEnd, event)
  );

  if (hasOverlap) {
    alert('Event time overlaps with an existing event. Please choose another time.');
    return;
  }

  // If no overlap, add the new event
  const newEvent = {
    id: Date.now(),
    start: `${clickedCellDate.value.format('YYYY-MM-DD')} ${selectedStartTime.value}`,
    end: `${clickedCellDate.value.format('YYYY-MM-DD')} ${selectedEndTime.value}`,
    title: 'You Added',
    class: 'addedSchedule',
    deletable: true,
  };

  events.value.push(newEvent);
  addedPendingSchedules.value.push(newEvent);
  emit('update:added-schedules', addedPendingSchedules.value);
};


//

function deleteSchedule(id) {
  addedPendingSchedules.value = addedPendingSchedules.value.filter(
    schedule => schedule.id !== id,
  )
  events.value = events.value.filter(schedule => schedule.id !== id)
  emit('update:added-schedules', addedPendingSchedules.value)
}

watch([selectedStartTime, selectedEndTime], () => {
  if (selectedStartTime.value && selectedEndTime.value) {
    addScheduleRequest()
  }
})
// VIEWS
const specialHours = computed(() => {
  return {
    1: dailyHours.value,
    2: dailyHours.value,
    3: dailyHours.value,
    4: dailyHours.value,
    5: dailyHours.value,
    6: dailyHours.value,
    7: dailyHours.value,
  }
})

const dailyHours = computed(() => {
  if (!props.tutorWorkDays) {
    return [
      { from: 6 * 60, to: 12 * 60, class: 'business-hours' },
      { from: 13 * 60, to: 23 * 60, class: 'business-hours' },
    ]
  }

  const tutorStartTime =
    formatTimeToInteger(props.tutorWorkDays.start_time) ?? 6
  const tutorEndTime = formatTimeToInteger(props.tutorWorkDays.end_time) ?? 23

  if (
    (tutorStartTime < 12 && tutorEndTime <= 12) ||
    (tutorStartTime >= 13 && tutorEndTime <= 23)
  ) {
    return [
      {
        from: tutorStartTime * 60,
        to: tutorEndTime * 60,
        class: 'business-hours',
      },
    ]
  }

  return [
    { from: tutorStartTime * 60, to: 12 * 60, class: 'business-hours' },
    { from: 13 * 60, to: tutorEndTime * 60, class: 'business-hours' },
  ]
})

const hiddenWeekDays = computed(() => {
  if (!props.tutorWorkDays) {
    return []
  }

  const dayToNumber = {
    monday: 1,
    tuesday: 2,
    wednesday: 3,
    thursday: 4,
    friday: 5,
    saturday: 6,
    sunday: 7,
  }

  return Object.keys(props.tutorWorkDays)
    .filter(day => !props.tutorWorkDays[day])
    .map(day => dayToNumber[day])
})

const activeView = ref('month')
const isDay = computed(() => {
  return activeView.value !== 'day'
})

const availableStartingDate = computed(() => {
  const date = new Date()
  date.setDate(date.getDate())
  return date
})

//WATCHES
watch(
  () => [props.tutorBookings, props.studentBookings],
  ([tutorBookings, studentBookings]) => {

    events.value = [
      ...tutorBookings?.flatMap(booking =>
        booking.booking_dates?.map(date => ({
          id: date.id,
          booking_id: booking.booking_id,
          start: formatRawDateTime(date.start_time),
          end: formatRawDateTime(date.end_time),
          title: booking.subject || '',
          class: 'tutorBookings',
        })) || []
      ) || [],
      ...studentBookings?.flatMap(booking =>
        booking.booking_dates?.map(date => ({
          id: date.id,
          booking_id: booking.booking_id,
          start: formatRawDateTime(date.start_time),
          end: formatRawDateTime(date.end_time),
          title: booking.subject || '',
          class: 'studentBookings',
        })) || []
      ) || []
    ]
  },
  {
    immediate: true,
    deep: true
  }
)
</script>

<style>
.vuecal__event.tutorBookings {
  background-color: rgba(250, 190, 61, 0.902);
  border: 1px solid rgba(255, 253, 248, 0.902);
  color: hsla(0, 0%, 100%, 0.902);
  font-size: 0.75em;
}

.vuecal__cell--before-min {
  color: #b6d6c7;
}

.vuecal__cell--after-max {
  color: #00f0f0;
}
</style>
