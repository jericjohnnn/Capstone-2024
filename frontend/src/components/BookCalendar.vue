<template>
  <div>
    <div class="">
      <button
        class="bg-green-400"
        :disabled="isDay"
        @click="isModalOpen = true"
      >
        Add Schedule
      </button>
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

    <!-- USE THIS AFTER TESTING HEHE -->
    <!-- :disable-views="['years', 'year', 'week']"
    hide-view-selector -->

    <vue-cal
      :click-to-navigate="isDay"
      v-model:active-view="activeView"
      :disable-views="['week']"
      :min-date="availableStartingDate"
      :hide-weekdays="hiddenWeekDays"
      :time-from="0 * 60"
      :time-to="25 * 60"
      :special-hours="specialHours"
      :events="events"
      @cell-click="storeCellDate"
      class="vuecal--full-height-delete"
      style="height: 500px"
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

    <div>
      <TimePickerModal
        :isModalOpen="isModalOpen"
        @update:start-time="updateStartTime"
        @update:end-time="updateEndTime"
        @close="closeModal"
      />
    </div>

    <!-- TESTING PURPOSES -->
    <!-- <JamalModal></JamalModal> -->

    <!-- TESTING PURPOSES -->
  </div>
</template>

<script setup>
import TimePickerModal from './TimePickerModal.vue'
import { ref, computed, watch } from 'vue'
import VueCal from 'vue-cal'
import 'vue-cal/dist/vuecal.css'

// TESTING PURPOSES!!

// import JamalModal from './JamalModal.vue'

// TESTING PURPOSES!!
const emit = defineEmits(['update:added-schedules'])

const props = defineProps({
  tutorDetails: {
    type: Object,
    required: true,
  },
  isBookSubmitted: {
    type: Boolean,
    required: true,
  },
  tutorBookings: {
    type: Array,
    default: () => [],
  },
})

watch(
  () => props.tutorBookings,
  newBookings => {
    events.value = newBookings.flatMap(booking =>
      booking.booking_dates.map(date => ({
        id: date.id,
        booking_id: booking.booking_id,
        start: new Date(date.start_time)
          .toISOString()
          .slice(0, 19)
          .replace('T', ' '), // Format to 'YYYY-MM-DD HH:mm:ss'
        end: new Date(date.end_time)
          .toISOString()
          .slice(0, 19)
          .replace('T', ' '), // Format to 'YYYY-MM-DD HH:mm:ss'
        title: booking.subject,
        class: 'tutorSchedule',
      })),
    )
  },
)

const isTutorDetailsLoaded = computed(() => !!props.tutorDetails)

const isModalOpen = ref(false)

const selectedStartTime = ref('')
const selectedEndTime = ref('')

const updateStartTime = time => {
  selectedStartTime.value = time
}

const updateEndTime = time => {
  selectedEndTime.value = time
}

const closeModal = () => {
  isModalOpen.value = false
}

const storeCellDate = event => {
  console.log(event)
  clickedCellDate.value = event
}

const clickedCellDate = ref()

const addedPendingSchedules = ref([])

const events = ref([])

const isEventOverlap = (newStart, newEnd, event) => {
  const existingStart = new Date(event.start).getTime()
  const existingEnd = new Date(event.end).getTime()

  return (
    (newStart < existingEnd && existingStart < newEnd) ||
    (newStart && newEnd == existingStart && existingEnd)
  )
}

const addScheduleRequest = () => {
  const newStart = new Date(
    `${clickedCellDate.value.format('YYYY-MM-DD')} ${selectedStartTime.value}`,
  ).getTime()
  const newEnd = new Date(
    `${clickedCellDate.value.format('YYYY-MM-DD')} ${selectedEndTime.value}`,
  ).getTime()

  const hasOverlap = events.value.some(event =>
    isEventOverlap(newStart, newEnd, event),
  )

  if (hasOverlap) {
    alert(
      'Event time overlaps with an existing event. Please choose another time.',
    )
    return
  }

  const newEvent = {
    id: Date.now(),
    start: `${clickedCellDate.value.format('YYYY-MM-DD')} ${selectedStartTime.value}`,
    end: `${clickedCellDate.value.format('YYYY-MM-DD')} ${selectedEndTime.value}`,
    title: 'You Added',
    class: 'addedSchedule',
    deletable: true,
  }

  events.value.push(newEvent)
  addedPendingSchedules.value.push(newEvent)
  emit('update:added-schedules', addedPendingSchedules.value)
}

function deleteSchedule(id) {
  addedPendingSchedules.value = addedPendingSchedules.value.filter(
    schedule => schedule.id !== id,
  )
  events.value = events.value.filter(schedule => schedule.id !== id)
  emit('update:added-schedules', addedPendingSchedules.value)
}

// calendar views
const activeView = ref('month')
const isDay = computed(() => activeView.value !== 'day')

// calendar min-date
const availableStartingDate = computed(() => {
  const date = new Date()
  date.setDate(date.getDate())
  return date
})

// calendar special hours
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

function formatTimeToInteger(timeString) {
  if (!timeString) return null // Return null if the input is empty or undefined

  const [hours] = timeString.split(':') // Split by ':' and take the hour part
  return parseInt(hours, 10) // Convert the hour to an integer
}

const dailyHours = computed(() => {
  if (!isTutorDetailsLoaded.value) {
    return [
      { from: 6 * 60, to: 12 * 60, class: 'business-hours' },
      { from: 13 * 60, to: 23 * 60, class: 'business-hours' },
    ]
  }

  const tutorStartTime =
    formatTimeToInteger(props.tutorDetails.work_days?.start_time) ?? 6
  const tutorEndTime =
    formatTimeToInteger(props.tutorDetails.work_days?.end_time) ?? 23

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
  if (!props.tutorDetails || !props.tutorDetails.work_days) {
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

  return Object.keys(props.tutorDetails.work_days)
    .filter(day => !props.tutorDetails.work_days[day])
    .map(day => dayToNumber[day])
})

watch([selectedStartTime, selectedEndTime], () => {
  if (selectedStartTime.value && selectedEndTime.value) {
    addScheduleRequest()
  }
})

watch(
  () => props.isBookSubmitted,
  () => {
    addedPendingSchedules.value = []
    events.value = events.value.filter(schedule => schedule.deletable !== true)
  },
)
</script>

<style>
.business-hours {
  background-color: rgba(255, 255, 0, 0.15);
  border: solid rgba(255, 210, 0, 0.3);
  border-width: 2px 0;
}
.vuecal__cell--disabled {
  text-decoration: line-through;
  color: #bbb;
}

.vuecal__cell--before-min {
  color: #b6d6c7;
}
.vuecal__cell--after-max {
  color: #00f0f0;
}

.vuecal__event.tutorSchedule {
  background-color: rgba(235, 235, 235, 0.9);
  border: 1px solid rgba(255, 255, 255, 0.9);
  color: #8d8d8d;
  font-size: 0.75em; /* Adjust font size as needed */
}

.vuecal__event.addedSchedule {
  background-color: rgba(36, 77, 255, 0.9);
  border: 1px solid rgba(231, 236, 255, 0.9);
  color: #fff;
  font-size: 0.75em; /* Adjust font size as needed */
}
</style>
