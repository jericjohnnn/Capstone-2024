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

    <vue-cal
      :click-to-navigate="isDay"
      :disable-views="['years', 'year', 'week']"
      v-model:active-view="activeView"
      :hide-weekdays="hiddenWeekDays"
      hide-view-selector
      :time-from="6 * 60"
      :time-to="23 * 60"
      :min-date="availableStartingDate"
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

    <!-- TESTING PURPOSES -->
    <div>
      <TimePickerModal
        :isModalOpen="isModalOpen"
        @update:start-time="updateStartTime"
        @update:end-time="updateEndTime"
        @close="closeModal"
      />

      <p>Start Time: {{ startTime }}</p>
      <p>End Time: {{ endTime }}</p>
    </div>

    <div>{{ clickedCellDate }}</div>
    <button class="bg-violet-400" @click="testt">Open testt</button>
    <div>
      {{ jamal }}
    </div>
    <!-- TESTING PURPOSES -->
  </div>
</template>

<script setup>
import TimePickerModal from './TimePickerModal.vue'
import { ref, computed, watch } from 'vue'
import VueCal from 'vue-cal'
import 'vue-cal/dist/vuecal.css'

// TESTING PURPOSES!!
const startTime = ref('')
const endTime = ref('')

const updateStartTime = time => {
  startTime.value = time
}

const updateEndTime = time => {
  endTime.value = time
}

const jamal = ref('jamal')

const testt = () => {
  jamal.value = `${clickedCellDate.value.format('YYYY-MM-DD')} ${startTime.value}`
}

// TESTING PURPOSES!!

const props = defineProps({
  tutorDetails: {
    type: Object,
    required: true,
  },
})

const isTutorDetailsLoaded = computed(() => !!props.tutorDetails)

const storeCellDate = event => {
  console.log(event)
  clickedCellDate.value = event
}

const clickedCellDate = ref()

const isModalOpen = ref(false)

// this will be sent for post
const addedPendingSchedules = ref([])

const events = ref([
  {
    id: 1,
    start: '2024-11-01 13:00:00',
    end: '2024-11-01 14:30:00',
    title: 'Math',
    class: 'tutorSchedule',
  },
  {
    id: 2,
    start: '2024-11-02 10:00:00',
    end: '2024-11-02 11:00:00',
    title: 'Science',
    class: 'tutorSchedule',
  },
])

const closeModal = () => {
  isModalOpen.value = false
}

const addScheduleRequest = () => {
  // for view
  events.value.push({
    id: Date.now(),
    start: `${clickedCellDate.value.format('YYYY-MM-DD')} ${startTime.value}`,
    end: `${clickedCellDate.value.format('YYYY-MM-DD')} ${endTime.value}`,
    title: 'You Added', // a
    class: 'addedSchedule',
    deletable: true,
  })
  // for post
  addedPendingSchedules.value.push({
    id: Date.now(),
    start: `${clickedCellDate.value.format('YYYY-MM-DD')} ${startTime.value}`,
    end: `${clickedCellDate.value.format('YYYY-MM-DD')} ${endTime.value}`,
    title: 'You Added',
    class: 'addedSchedule',
    deletable: true,
  })
}

watch([startTime, endTime], () => {
  if (startTime.value && endTime.value) {
    addScheduleRequest()
  }
})

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

const dailyHours = computed(() => {
  if (!isTutorDetailsLoaded.value) {
    return [
      { from: 6 * 60, to: 12 * 60, class: 'business-hours' },
      { from: 13 * 60, to: 23 * 60, class: 'business-hours' },
    ]
  }

  const startTime = props.tutorDetails.work_days?.start_time ?? 6
  const endTime = props.tutorDetails.work_days?.end_time ?? 23

  if ((startTime < 12 && endTime <= 12) || (startTime >= 13 && endTime <= 23)) {
    return [{ from: startTime * 60, to: endTime * 60, class: 'business-hours' }]
  }

  return [
    { from: startTime * 60, to: 12 * 60, class: 'business-hours' },
    { from: 13 * 60, to: endTime * 60, class: 'business-hours' },
  ]
})
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
