<template>
  <main>
    <SideBar>
      <main class="container mx-auto">
        <BreadCrumb
          :breadcrumbs="[
            { label: 'Home', route: '/student/home' },
            { label: 'Book', route: '/student/book/:tutorId' },
          ]"
        />
        <div class="flex gap-8 mt-6">
          <!-- Left Column - Calendar -->
          <div class="w-1/2">
            <!-- Availability Info -->
            <div class="mb-4">
              <p v-if="!tutorDetails.work_days || tutorDetails.work_days.length === 0"
                class="text-gray-600"
              >
                No availability
              </p>
              <p v-else class="text-gray-600">
                {{ tutorDetails.first_name }} {{ tutorDetails.last_name }} is
                available {{ formatTo12Hour(tutorDetails.work_days.start_time) }} -
                {{ formatTo12Hour(tutorDetails.work_days.end_time) }}
              </p>
            </div>
            <div v-if="!tutorDetails">
              <p class="text-center text-gray-500">LOADING</p>
            </div>
            <div v-else>
              <BookCalendar
                :tutorDetails="tutorDetails"
                :tutorBookings="tutorBookings"
                :isBookSubmitted="isBookSubmitted"
                @update:added-schedules="addSchedules"
              />
            </div>
          </div>

          <!-- Right Column - Tutor Info & Form -->
          <div class="w-1/2">
            <!-- Tutor Info and Booking Form -->
            <div>
              <div class="flex items-center gap-6 mb-4">
                <img
                  :src="tutorDetails.profile_image"
                  alt="Tutor"
                  class="w-20 h-20 rounded-full object-cover"
                />
                <div class="flex-1">
                  <StarRating :rating="averageRatings" class="mb-1" />
                  <h2 class="text-xl font-semibold mb-2">
                    {{ tutorDetails.first_name }} {{ tutorDetails.last_name }}
                  </h2>
                  <div class="flex flex-wrap gap-2">
                    <span
                      v-for="subject in tutorDetails.subjects"
                      :key="subject.id"
                      class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm"
                    >
                      {{ subject.name }}
                    </span>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-lg font-semibold text-blue-600">
                    ₱{{ tutorDetails.tutor_rate }}/Hour
                  </p>
                </div>
              </div>

              <hr class="my-4" />

              <!-- Booking Form -->
              <form @submit.prevent="submitBookingRequest" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                  <!-- Subject Selection -->
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select subject:</label>
                    <select
                      v-model="bookingState.selectedSubject"
                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
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

                  <!-- Mode of Tutoring -->
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Learning preference:</label>
                    <select
                      v-model="bookingState.modeOfTutoring"
                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                      <option value="In School">In School</option>
                      <option value="Online">Online</option>
                      <option value="Face to Face">Face to Face</option>
                    </select>
                  </div>
                </div>

                <!-- Location/Platform -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    {{ bookingState.modeOfTutoring === 'Online' ? 'Video Platform:' : 'Location:' }}
                  </label>
                  <select
                    v-if="bookingState.modeOfTutoring === 'Online'"
                    v-model="bookingState.videoPlatform"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                  >
                    <option value="Zoom">Zoom</option>
                    <option value="Google Meet">Google Meet</option>
                    <option value="Skype">Skype</option>
                  </select>
                  <input
                    v-else-if="bookingState.modeOfTutoring === 'Face to Face'"
                    v-model="bookingState.location"
                    type="text"
                    placeholder="Enter location"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                  />
                  <div
                    v-else
                    class="w-full p-2 bg-gray-50 rounded-md text-gray-700"
                  >
                    {{ bookingState.location }}
                  </div>
                </div>

                <!-- Message -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Message:</label>
                  <div class="border border-gray-300 rounded-md overflow-hidden">
                    <input
                      v-model="bookingState.tutorTopic"
                      placeholder="Enter the topic that needs tutoring"
                      class="w-full border-b border-gray-300 p-3 focus:outline-none focus:ring-0 focus:border-blue-500"
                    />
                    <textarea
                      v-model="bookingState.tutorMessage"
                      placeholder="Enter objectives, concerns, and further details of your inquiry"
                      class="w-full p-3 h-32 resize-none focus:outline-none focus:ring-0 focus:border-blue-500"
                    />
                  </div>
                </div>

                <!-- Contact Number -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Contact number:</label>
                  <div class="flex gap-2">
                    <input
                      v-model="bookingState.contactNumber"
                      type="text"
                      :readonly="isReadonly"
                      class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    />
                    <button
                      type="button"
                      @click="toggleEditing"
                      class="px-3 py-1 text-sm text-blue-600 hover:text-blue-700"
                    >
                      {{ isReadonly ? 'Change number' : 'Apply' }}
                    </button>
                    <button
                      v-if="!isReadonly"
                      type="button"
                      @click="cancelChanges"
                      class="px-3 py-1 text-sm text-gray-600 hover:text-gray-700"
                    >
                      Cancel
                    </button>
                  </div>
                </div>

                <!-- Form Buttons -->
                <div class="flex justify-end gap-4 pt-4">
                  <router-link :to="{ name: 'StudentHome' }">
                    <button
                      type="button"
                      class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200"
                    >
                      Cancel
                    </button>
                  </router-link>
                  <button
                    type="submit"
                    class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700"
                  >
                    BOOK
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </main>
    </SideBar>
  </main>
</template>

<script setup>
import StarRating from '@/components/StarRating.vue'
import BreadCrumb from '@/components/BreadCrumb.vue'
import { ref, reactive, onMounted, watch, computed } from 'vue'
import { useRoute } from 'vue-router'
import axiosInstance from '@/axiosInstance'
import BookCalendar from '@/components/shared/calendar/BookCalendar.vue'
import SideBar from '@/components/SideBar.vue'
// import HelpButton from '@/components/HelpButton.vue'
import { getUserData } from '@/utils/user'
import { formatTo12Hour } from '@/utils/dateTime'

const userData = getUserData()

const route = useRoute()
const tutorDetails = ref({})
const modifiedContactNumber = ref('')

const isReadonly = ref(true)

const averageRatings = computed(() => {
  if (!tutorDetails.value?.ratings || tutorDetails.value.ratings.length === 0) {
    return 0
  }
  const ratings = tutorDetails.value.ratings.map(rating => rating.rate)
  const total = ratings.reduce((sum, rate) => sum + rate, 0)
  return total / ratings.length
})

// Convert multiple refs to a reactive state object
const initialBookingState = {
  selectedSubject: '',
  modeOfTutoring: 'In School',
  location: 'CCTC',
  videoPlatform: '',
  contactNumber: userData.value.contact_number || '',
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
    student_id: userData.value.id,
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
  } catch (error) {
    console.error('Error submitting form:', error)
    console.log(bookingState.selectedDateTimes)

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
