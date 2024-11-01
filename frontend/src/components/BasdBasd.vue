<template>
  <div>
    <div>
            <button class="bg-green-400" @click="addE">ADD EVENT</button>
            <div v-for="sched in newSched" :key="sched.id">
              {{ sched }}
            </div>
          </div>
          <vue-cal
            :disable-views="['years', 'year', 'week']"
            hide-view-selector
            :time-from="6 * 60"
            :time-to="23 * 60"
            :min-date="minDate"
            :special-hours="specialHours"
            :events="events"
            :hide-weekdays="hiddenWeekDays"
            v-model:active-view="activeView"
            :click-to-navigate="isDay"
            class="vuecal--full-height-delete"
            style="height: 500px"
          >
            <template #title="{ view }">
              🎉
              <span v-if="view.id === 'month'">{{
                view.startDate.format('MMMM YYYY')
              }}</span>
              <span v-if="view.id === 'day'">{{
                view.endDate.format('dddd D MMMM (YYYY)')
              }}</span>
              🎉
            </template>
          </vue-cal>
          <div>
            {{ activeView }}
          </div>
          <button class="bg-red-400" @click="removeE">REMOVE EVENT</button>
          <button class="bg-blue-400" @click="showcl">console log EVENT</button>
  </div>
</template>
<script setup>
import { ref, computed } from 'vue'
import VueCal from 'vue-cal'
import 'vue-cal/dist/vuecal.css'

const props = defineProps({
  tutorDetails: {
    type: Object,
    required: true,
  },
})



const activeView = ref('month')
// const dayView = ref('day')


// function onEventDelete(event) {
//   // Assuming the event has an 'id' property
//   events.value = events.value.filter(e => e.id !== event.id)
//   alert(`Event "${event.title}" has been deleted.`)
// }

const events = ref([
  {
    id: 1,
    start: new Date('2024-11-01T13:00:00'),
    end: new Date('2024-11-1 14:30'),
    title: 'Math',
    class: 'health',
    deletable: false,
  },
  {
    id: 2,
    start: '2024-11-2 10:00',
    end: '2024-11-2 11:00',
    title: 'Science',
    class: 'work',
    deletable: false,
  },
  // Add more events as needed, using a similar format.
])
// event
const newSched = ref([])

const addE = () => {
  if (activeView.value === 'day') {
    events.value.push({
      id: 3,
      start: '2024-11-2 15:00',
      end: '2024-11-2 18:30',
      title: 'Doctor appointment',
      class: 'zz',
      deletable: true,
    })
    newSched.value.push({
      id: 3,
      start: '2024-11-2 15:00',
      end: '2024-11-2 18:30',
      title: 'Doctor appointment',
      class: 'zz',
      deletable: true,
    })
  }
}

// function onEventCreate(newEvent) {
//   const newEventStart = new Date(newEvent.start)
//   let newEventEnd = new Date(newEvent.end)

//   const isOverlapping =
//     newEventStart < events.value[0].end && newEventEnd > events.value[0].start

//   if (isOverlapping) {
//     alert(
//       'Event time overlaps with an existing event. Please choose another time.',
//     )
//     newEventEnd = new Date('2024-11-01T12:00:00')
//     // insert logic here
//     return
//   }

//   alert(`Event "${newEvent.start}" has been created.`)

//   return newEvent
// }

// const events = computed(() => [
//   {
//     start: '2024-11-1 13:00',
//     end: '2024-11-1 14:30',
//     title: 'Doctor appointment',
//     class: 'health',
//   },
//   {
//     start: '2024-11-2 10:00',
//     end: '2024-11-2 11:00',
//     title: 'Meeting with team',
//     class: 'work',
//   },
//   // Add more events as needed, using a similar format.
// ])

const isDay = computed(() => {
  if (activeView.value == 'day') {
    return false
  }
  return true
})

const removeE = () => {
  events.value = events.value.filter(event => event.id !== 3)
  newSched.value = newSched.value.filter(event => event.id !== 3)
}

const showcl = () => {
  console.log(events.value)
  console.log(newSched.value)
}

const dailyHours = computed(() => {
  const startTime = props.tutorDetails.value.work_days?.start_time ?? 6
  const endTime = props.tutorDetails.value.work_days?.end_time ?? 23

  if ((startTime < 12 && endTime <= 12) || (startTime >= 13 && endTime <= 23)) {
    return [{ from: startTime * 60, to: endTime * 60, class: 'business-hours' }]
  }

  return [
    { from: startTime * 60, to: 12 * 60, class: 'business-hours' },
    { from: 13 * 60, to: endTime * 60, class: 'business-hours' },
  ]
})

// Make specialHours reactive
const specialHours = computed(() => ({
  1: dailyHours.value,
  2: dailyHours.value,
  3: dailyHours.value,
  4: dailyHours.value,
  5: dailyHours.value,
  6: dailyHours.value,
  7: dailyHours.value,
}))

const minDate = computed(() => {
  const date = new Date()
  date.setDate(date.getDate())
  return date
})

// // for disabling specific day of a week
const hiddenWeekDays = computed(() => {
  if (!props.tutorDetails.value.work_days) {
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

  return Object.keys(props.tutorDetails.value.work_days)
    .filter(day => !props.tutorDetails.value.work_days[day])
    .map(day => dayToNumber[day])
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

.vuecal__event.health {
  background-color: rgba(253, 156, 66, 0.9);
  border: 1px solid rgb(233, 136, 46);
  color: #fff;
  font-size: 0.75em; /* Adjust font size as needed */
}

.vuecal__event.work {
  background-color: rgba(255, 102, 102, 0.9);
  border: 1px solid rgb(235, 82, 82);
  color: #fff;
  font-size: 0.75em; /* Adjust font size as needed */
}


</style>
