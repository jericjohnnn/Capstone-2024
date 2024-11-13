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
              <p
                v-if="
                  !tutorDetails.work_days || tutorDetails.work_days.length === 0
                "
                class="text-gray-600"
              >
                No availability
              </p>
              <p v-else class="text-gray-600">
                {{ tutorDetails.first_name }} {{ tutorDetails.last_name }} is
                available
                {{ formatTo12Hour(tutorDetails.work_days.start_time) }} -
                {{ formatTo12Hour(tutorDetails.work_days.end_time) }}
              </p>
            </div>
            <div v-if="!tutorDetails">
              <p class="text-center text-gray-500">LOADING</p>
            </div>
            <div v-else>
              <BookCalendar
                :tutorBookings="tutorBookings"
                :tutorWorkDays="tutorWorkDays"
                :studentBookings="studentBookings"
                @update:added-schedules="storePendingBookingDates"
              />
            </div>
          </div>

          <!-- Right Column - Tutor Info & Form -->
          <div class="w-1/2">
            <!-- Tutor Info and Booking Form -->
            <div>
              <div>
                <TutorInfo :tutor="tutorDetails" />
              </div>

              <hr class="my-4" />

              <!-- Booking Form -->
              <form @submit.prevent="submitBookingRequest" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                  <!-- Subject Selection -->
                  <div>
                    <SelectSubject
                      :tutor="tutorDetails"
                      @update:selectedSubject="updateSelectedSubject"
                    />
                  </div>

                  <!-- Mode of Tutoring -->
                  <div>
                    <SelectLearningPreference
                      @update:learningPreference="updateLearningPreference"
                    />
                  </div>
                </div>

                <!-- Location/Platform -->
                <div>
                  <SelectLocationOrPlatform
                    :learningPreference="bookingState.learningPreference"
                    :inSchoolAddress="bookingState.location"
                    @update:videoPlatform="updateVideoPlatform"
                    @update:location="updateLocation"
                  />
                </div>

                <!-- Message -->
                <div>
                  <InputMessage
                    @update:tutorTopic="updateTutorTopic"
                    @update:tutorMessage="updateTutorMessage"
                  />
                </div>

                <!-- Contact Number -->
                <div>
                  <ChangeContactNumber
                    :contactNumber="bookingState.contactNumber"
                    @update:contactNumber="updateContactNumber"
                  />
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
import ChangeContactNumber from '@/components/student/StudentBookTutor/form/changeContactNumber.vue'
import InputMessage from '@/components/student/StudentBookTutor/form/InputMessage.vue'
import SelectLocationOrPlatform from '@/components/student/StudentBookTutor/form/SelectLocationOrPlatform.vue'
import SelectSubject from '@/components/student/StudentBookTutor/form/SelectSubject.vue'
import SelectLearningPreference from '@/components/student/StudentBookTutor/form/SelectLearningPreference.vue'
import TutorInfo from '@/components/student/StudentBookTutor/TutorInfo.vue'
import BreadCrumb from '@/components/BreadCrumb.vue'
import { ref, reactive, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import axiosInstance from '@/axiosInstance'
import BookCalendar from '@/components/shared/calendar/BookCalendar.vue'
import SideBar from '@/components/SideBar.vue'
// import HelpButton from '@/components/HelpButton.vue'
import { getUserData } from '@/utils/user'
import { formatTo12Hour } from '@/utils/dateTime'

const userData = getUserData()

const tutorBookings = ref([])
const studentBookings = ref([])
const tutorWorkDays = ref({})

const route = useRoute()
const tutorDetails = ref({})

// const modifiedContactNumber = ref('')

const updateSelectedSubject = newSubject => {
  bookingState.selectedSubject = newSubject
}

const updateLearningPreference = newPreference => {
  bookingState.learningPreference = newPreference
}

const updateVideoPlatform = newPlatform => {
  bookingState.videoPlatform = newPlatform
}

const updateLocation = newLocation => {
  bookingState.location = newLocation
}

const updateTutorTopic = newTopic => {
  bookingState.tutorTopic = newTopic
}

const updateTutorMessage = newMessage => {
  bookingState.tutorMessage = newMessage
}

const updateContactNumber = newContactNumber => {
  bookingState.contactNumber = newContactNumber
}

const initialBookingState = {
  selectedSubject: '',
  learningPreference: 'In School',
  location: 'CCTC',
  videoPlatform: '',
  contactNumber: userData.value.contact_number || '',
  tutorTopic: '',
  tutorMessage: '',
  selectedDateTimes: [],
}

const bookingState = reactive({ ...initialBookingState })

const storePendingBookingDates = bookingDates => {
  bookingState.selectedDateTimes = bookingDates
}

const submitBookingRequest = async () => {
  const bookRequest = {
    tutor_id: route.params.tutorId,
    student_id: userData.value.id,
    subject: bookingState.selectedSubject,
    learning_mode: bookingState.learningPreference,
    location:
      bookingState.learningPreference === 'Face to Face' ||
      bookingState.learningPreference === 'In School'
        ? bookingState.location
        : null,
    online_meeting_platform:
      bookingState.learningPreference === 'Online'
        ? bookingState.videoPlatform
        : null,
    contact_number: bookingState.contactNumber,
    message_title: bookingState.tutorTopic,
    message_content: bookingState.tutorMessage,
    selected_date_times: bookingState.selectedDateTimes,
  }

  try {
    await axiosInstance.post('api/create-booking', bookRequest)

    Object.assign(bookingState, initialBookingState)
  } catch (error) {
    console.error('Error submitting form:', error)

    alert('There was an error submitting the form.')
  }
}

const fetchTutorSchedules = async tutorId => {
  try {
    const response = await axiosInstance.get(`/api/tutor-schedules/${tutorId}`)
    const { message, bookings } = response.data

    if (message == 'Tutor not found or has no bookings.') {
      tutorBookings.value = []
    }
    tutorBookings.value = bookings
  } catch (err) {
    console.error('Error fetching tutor details:', err)
  }
}

const fetchTutorDetails = async tutorId => {
  try {
    const response = await axiosInstance.get(`/api/tutor-detail/${tutorId}`)
    tutorDetails.value = response.data.tutor
    tutorWorkDays.value = tutorDetails.value.work_days
  } catch (err) {
    console.error('Error fetching tutor details:', err)
  }
}

// Update watch to use bookingState
watch(
  () => bookingState.learningPreference,
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
