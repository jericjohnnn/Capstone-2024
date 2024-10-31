<template>
  <main class="p-4">
    <SideBar>
      <main class="container mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">
          <!-- Tutor Info -->
          <div class="flex items-center mb-4">
            <img
              :src="tutorDetails.profile_image"
              alt="Tutor"
              class="w-16 h-16 rounded-full"
            />
            <div class="ml-4">
              <h2 class="text-xl font-semibold">
                {{ tutorDetails.first_name }} {{ tutorDetails.last_name }}
              </h2>
              <div
                v-if="
                  !tutorDetails.subjects || tutorDetails.subjects.length === 0
                "
              >
                <p>No subjects</p>
              </div>
              <div v-else class="flex flex-wrap gap-1">
                <span
                  v-for="subject in tutorDetails.subjects"
                  :key="subject.id"
                  class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm"
                >
                  {{ subject.name }}
                </span>
              </div>
            </div>
          </div>

          <div class="text-sm text-gray-600 mb-4">
            <p
              v-if="
                !tutorDetails.work_days || tutorDetails.work_days.length === 0
              "
            >
              No availability
            </p>
            <p v-else>
              {{ tutorDetails.first_name }} {{ tutorDetails.last_name }} is
              available {{ tutorDetails.work_days.start_time }} -
              {{ tutorDetails.work_days.end_time }}
              <span class="float-right"
                >Rate: P{{ tutorDetails.tutor_rate }}/Hour</span
              >
            </p>
          </div>

          <!-- click-to-navigate -->
          <vue-cal
            :disable-views="['years', 'year', 'week']"
            hide-view-selector
            :time-from="6 * 60"
            :time-to="23 * 60"
            :min-date="minDate"
            :special-hours="specialHours"
            :events="events"
            :hide-weekdays="hiddenWeekDays"
            @cell-click="addE"
            v-model:active-view="activeView"
            :click-to-navigate="isDay"
            :editable-events="{ title: true, delete: true, create: true }"
            overlaps-per-time-step
            @event-drag-create="onEventCreate"
            :snap-to-time="30"
            class="vuecal--full-height-delete"
            style="height: 600px"
          >
            <template #title="{ view }">
              🎉
              <span v-if="view.id === 'month'">{{
                view.startDate.format('MMMM YYYY')
              }}</span>
              <span v-if="view.id === 'day'">{{
                view.startDate.format('dddd D MMMM (YYYY)')
              }}</span>
              🎉
            </template>
          </vue-cal>
          <div>
            {{ activeView }}
          </div>
          <!-- Booking Form -->
          <form @submit.prevent="handleSubmit" class="space-y-4">
            <div>
              <label class="block text-gray-700">Select subject:</label>
              <select
                v-model="selectedSubject"
                class="border rounded w-full p-2"
              >
                <option value="">Select Subject</option>
                <option
                  v-for="subject in tutorDetails.subjects"
                  :key="subject.id"
                  :value="subject.name"
                >
                  {{ subject.name }}
                </option>
              </select>
            </div>

            <div>
              <label class="block text-gray-700"
                >Choose mode of tutoring:</label
              >
              <select
                v-model="modeOfTutoring"
                class="border rounded w-full p-2"
              >
                <option value="In School">In School</option>
                <option value="Online">Online</option>
                <option value="Face to Face">Face to Face</option>
              </select>
            </div>

            <div>
              <label class="block text-gray-700">
                {{
                  modeOfTutoring === 'Online'
                    ? 'Select Video Conferencing Platform:'
                    : 'Location:'
                }}
              </label>

              <select
                v-if="modeOfTutoring === 'Online'"
                v-model="videoPlatform"
                class="border rounded w-full p-2"
              >
                <option value="Zoom">Zoom</option>
                <option value="Google Meet">Google Meet</option>
                <option value="Skype">Skype</option>
              </select>

              <input
                v-else-if="modeOfTutoring === 'Face to Face'"
                v-model="location"
                type="text"
                class="border rounded w-full p-2"
                placeholder="Enter location"
              />

              <div
                v-else
                class="border rounded w-full p-2 bg-gray-100 text-gray-700"
              >
                {{ location }}
              </div>
            </div>

            <div class="border rounded p-2">
              <label class="block text-gray-700">Message:</label>
              <input
                v-model="tutorTopic"
                class="w-full border-none outline-none mb-1"
                placeholder="Enter the topic that needs tutoring"
              />
              <textarea
                v-model="tutorMessage"
                class="w-full border-none outline-none mt-1 h-24 resize-none"
                placeholder="Enter objectives, concerns, and further details of your inquiry"
              ></textarea>
            </div>

            <div>
              <label class="block text-gray-700">Contact number:</label>
              <input
                v-model="contactNumber"
                type="text"
                class="border rounded w-full p-2"
                :readonly="isReadonly"
              />
              <div class="mt-2">
                <button
                  type="button"
                  class="text-blue-600 hover:underline mr-2"
                  @click="toggleEditing"
                >
                  {{ isReadonly ? 'Change number' : 'Apply' }}
                </button>
                <button
                  v-if="!isReadonly"
                  type="button"
                  class="text-green-600 hover:underline"
                  @click="cancelChanges"
                >
                  cancel
                </button>
              </div>
            </div>

            <div class="flex justify-end gap-4">
              <router-link :to="{ name: 'StudentHome' }">
                <button
                  type="button"
                  class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100"
                >
                  Cancel
                </button>
              </router-link>
              <button
                type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
              >
                BOOK
              </button>
            </div>
          </form>
        </div>
        <button class="bg-green-400" @click="addE">ADD EVENT</button>
        <button class="bg-red-400" @click="removeE">REMOVE EVENT</button>
        <button class="bg-blue-400" @click="showcl">console log EVENT</button>
      </main>
    </SideBar>
    <HelpButton />
  </main>
</template>

<script setup>
import SideBar from '@/components/SideBar.vue'
import HelpButton from '@/components/HelpButton.vue'
import { ref, onMounted, watch, computed } from 'vue'
import { useRoute } from 'vue-router'
import axiosInstance from '@/axiosInstance'
import VueCal from 'vue-cal'
import 'vue-cal/dist/vuecal.css'

const route = useRoute()

const activeView = ref('month')
// const dayView = ref('day')

const tutorDetails = ref({})

function onEventDelete(event) {
  // Assuming the event has an 'id' property
  events.value = events.value.filter(e => e.id !== event.id)
  alert(`Event "${event.title}" has been deleted.`)
}

const events = ref([
  {
    id: 1,
    start: new Date('2024-11-01T13:00:00'),
    end: new Date('2024-11-1 14:30'),
    title: 'Doctor appointment',
    class: 'health',
    deletable: false,
  },
  {
    id: 2,
    start: '2024-11-2 10:00',
    end: '2024-11-2 11:00',
    title: 'Meeting with team',
    class: 'work',
    deletable: false,
  },
  // Add more events as needed, using a similar format.
])
// event
function onEventCreate(newEvent) {
  const newEventStart = new Date(newEvent.start)
  let newEventEnd = new Date(newEvent.end)

  const isOverlapping =
    newEventStart < events.value[0].end && newEventEnd > events.value[0].start

  if (isOverlapping) {
    alert(
      'Event time overlaps with an existing event. Please choose another time.',
    )
    newEventEnd = new Date('2024-11-01T12:00:00')
    // insert logic here
    return
  }

  alert(`Event "${newEvent.start}" has been created.`)

  return newEvent
}

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
  if(activeView.value == 'day'){
    return false
  }
  return true
})

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
  }
}

const removeE = () => {
  events.value = events.value.filter(event => event.id !== 3)
}

const showcl = () => {
  console.log(events.value)
}

const dailyHours = computed(() => {
  const startTime = tutorDetails.value.work_days?.start_time ?? 6
  const endTime = tutorDetails.value.work_days?.end_time ?? 23

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
  if (!tutorDetails.value.work_days) {
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

  return Object.keys(tutorDetails.value.work_days)
    .filter(day => !tutorDetails.value.work_days[day])
    .map(day => dayToNumber[day])
})

const getUserData = localStorage.getItem('user_data')
const userData = getUserData ? JSON.parse(getUserData) : null
const studentContactNumber = userData ? userData.contact_number : null
const modifiedContactNumber = ref('')

const isReadonly = ref(true)

const selectedSubject = ref('')
const tutorTopic = ref('')
const tutorMessage = ref('')
const contactNumber = ref(studentContactNumber)
const modeOfTutoring = ref('In School')
const location = ref('CCTC')
const videoPlatform = ref('')

const toggleEditing = () => {
  isReadonly.value = !isReadonly.value
  modifiedContactNumber.value = contactNumber.value
}

const cancelChanges = () => {
  contactNumber.value = modifiedContactNumber.value
  isReadonly.value = true
}

const handleSubmit = async () => {
  console.log({
    subject: selectedSubject.value,
    message: tutorMessage.value,
    contactNumber: contactNumber.value,
    modeOfTutoring: modeOfTutoring.value,
    location: location.value,
    sn: studentContactNumber,
  })

  // Add your submission logic here, like an API call
}

const fetchTutorDetails = async tutorId => {
  try {
    const response = await axiosInstance.get(`/api/tutor-detail/${tutorId}`)
    tutorDetails.value = response.data.tutor
  } catch (err) {
    console.error('Error fetching tutor details:', err)
  }
}

watch(modeOfTutoring, newMode => {
  if (newMode === 'In School') {
    location.value = 'CCTC'
  } else if (newMode === 'Face to Face') {
    location.value = ''
  }
})

onMounted(() => {
  const initialTutorId = route.params.tutorId
  if (initialTutorId) {
    fetchTutorDetails(initialTutorId)
  }
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

/* :deep(.vuecal__cell--disabled) {
  background-color: #f5f5f5;
  cursor: not-allowed;
} */

/* .vuecal__cell--disabled {text-decoration: line-through;color: #bbb;} */
</style>
