<template>
  <main class="">
    <SideBar>
      <main class="container p-5 mx-auto">
        <BreadCrumb
          :breadcrumbs="[
            { label: 'Home', route: '/student/home' },
            { label: 'Book', route: '/student/book/:tutorId' },
          ]"
        />
        <div class="bg-white shadow-md rounded-lg p-6">
          <!-- Tutor Info section remains unchanged -->
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
              available {{ formatTo12HourTime(tutorDetails.work_days.start_time) }} -
              {{ formatTo12HourTime(tutorDetails.work_days.end_time) }}
              <span class="float-right"
                >Rate: P{{ tutorDetails.tutor_rate }}/Hour</span
              >
            </p>
          </div>
          <div v-if="!tutorDetail">
            <p class="text-center text-gray-500">LOADING</p>
          </div>
          <div v-else>
            <BookCalendar
              :tutorDetails="tutorDetails"
              :tutorBookings="tutorBookings"
              :isBookSubmitted="isBookSubmitted"
              @update:added-schedules="addSchedules"
            ></BookCalendar>
          </div>

          <!-- Updated Booking Form with bookingState -->
          <form @submit.prevent="submitBookingRequest" class="space-y-4">
            <div>
              <label class="block text-gray-700">Select subject:</label>
              <select
                v-model="bookingState.selectedSubject"
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
                v-model="bookingState.modeOfTutoring"
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
                  bookingState.modeOfTutoring === 'Online'
                    ? 'Select Video Conferencing Platform:'
                    : 'Location:'
                }}
              </label>

              <select
                v-if="bookingState.modeOfTutoring === 'Online'"
                v-model="bookingState.videoPlatform"
                class="border rounded w-full p-2"
              >
                <option value="Zoom">Zoom</option>
                <option value="Google Meet">Google Meet</option>
                <option value="Skype">Skype</option>
              </select>

              <input
                v-else-if="bookingState.modeOfTutoring === 'Face to Face'"
                v-model="bookingState.location"
                type="text"
                class="border rounded w-full p-2"
                placeholder="Enter location"
              />

              <div
                v-else
                class="border rounded w-full p-2 bg-gray-100 text-gray-700"
              >
                {{ bookingState.location }}
              </div>
            </div>

            <div class="border rounded p-2">
              <label class="block text-gray-700">Message:</label>
              <input
                v-model="bookingState.tutorTopic"
                class="w-full border-none outline-none mb-1"
                placeholder="Enter the topic that needs tutoring"
              />
              <textarea
                v-model="bookingState.tutorMessage"
                class="w-full border-none outline-none mt-1 h-24 resize-none"
                placeholder="Enter objectives, concerns, and further details of your inquiry"
              ></textarea>
            </div>

            <div>
              <label class="block text-gray-700">Contact number:</label>
              <input
                v-model="bookingState.contactNumber"
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
      </main>
    </SideBar>

    <HelpButton />
  </main>
</template>

<script setup>
import BreadCrumb from '@/components/BreadCrumb.vue'
import { ref, reactive, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import axiosInstance from '@/axiosInstance'
import BookCalendar from '@/components/BookCalendar.vue'
import SideBar from '@/components/SideBar.vue'
import HelpButton from '@/components/HelpButton.vue'

const route = useRoute()
const tutorDetails = ref({})
const tutorDetail = ref(null)

const getUserData = localStorage.getItem('user_data')
const userData = getUserData ? JSON.parse(getUserData) : null
const studentContactNumber = userData ? userData.contact_number : null
const modifiedContactNumber = ref('')

const isReadonly = ref(true)

function formatTo12HourTime(timeString) {
  if (!timeString) return null;

  const [hours, minutes] = timeString.split(':');
  let hour = parseInt(hours, 10);
  const ampm = hour >= 12 ? 'PM' : 'AM';

  hour = hour % 12 || 12;

  return `${hour}:${minutes} ${ampm}`;
}

// Convert multiple refs to a reactive state object
const initialBookingState = {
  selectedSubject: '',
  modeOfTutoring: 'In School',
  location: 'CCTC',
  videoPlatform: '',
  contactNumber: studentContactNumber,
  tutorTopic: '',
  tutorMessage: '',
  selectedDateTimes: [],
}

const bookingState = reactive({ ...initialBookingState })

const addSchedules = schedules => {
  const startAndEndArray = schedules.map(item => ({
    start: item.start,
    end: item.end,
  }))

  bookingState.selectedDateTimes = startAndEndArray
}

const toggleEditing = () => {
  isReadonly.value = !isReadonly.value
  modifiedContactNumber.value = bookingState.contactNumber
}

const cancelChanges = () => {
  bookingState.contactNumber = modifiedContactNumber.value
  isReadonly.value = true
}
const isBookSubmitted = ref(true)

const submitBookingRequest = async () => {
  const bookRequest = {
    tutor_id: route.params.tutorId,
    student_id: userData.id,
    subject: bookingState.selectedSubject,
    learning_mode: bookingState.modeOfTutoring,
    location:
      bookingState.modeOfTutoring === 'Face to Face' ||
      bookingState.modeOfTutoring === 'In School'
        ? bookingState.location
        : null,
    online_meeting_platform:
      bookingState.modeOfTutoring === 'Online'
        ? bookingState.videoPlatform
        : null,
    contact_number: bookingState.contactNumber,
    message_title: bookingState.tutorTopic,
    message_content: bookingState.tutorMessage,
    selected_date_times: bookingState.selectedDateTimes,
  }

  try {
    const response = await axiosInstance.post('api/create-booking', bookRequest)
    console.log(response)

    // Reset bookingState to its initial state

    Object.assign(bookingState, initialBookingState)
    isBookSubmitted.value = !isBookSubmitted.value
    console.log(isBookSubmitted.value)

    console.log(bookRequest)
  } catch (error) {
    console.error('Error submitting form:', error)
    alert('There was an error submitting the form.')
  }
}

const tutorBookings = ref([])

const fetchTutorSchedules = async tutorId => {
  try {
    const response = await axiosInstance.get(`/api/tutor-schedules/${tutorId}`)
    const { message, bookings } = response.data

    if (message == 'Tutor not found or has no bookings.') {
      tutorBookings.value = []
    }
    tutorBookings.value = bookings
    console.log(tutorBookings.value)
  } catch (err) {
    console.error('Error fetching tutor details:', err)
  }
}

const fetchTutorDetails = async tutorId => {
  try {
    const response = await axiosInstance.get(`/api/tutor-detail/${tutorId}`)
    tutorDetails.value = response.data.tutor
    tutorDetail.value = response.data
  } catch (err) {
    console.error('Error fetching tutor details:', err)
  }
}

// Update watch to use bookingState
watch(
  () => bookingState.modeOfTutoring,
  newMode => {
    if (newMode === 'In School') {
      bookingState.location = 'CCTC'
    } else if (newMode === 'Face to Face') {
      bookingState.location = ''
    }
  },
)

onMounted(() => {
  const initialTutorId = route.params.tutorId
  if (initialTutorId) {
    fetchTutorDetails(initialTutorId)
    fetchTutorSchedules(initialTutorId)
  }
})
</script>
