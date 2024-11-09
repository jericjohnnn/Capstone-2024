<template>
  <main class="bg-blue-50">
    <SideBar>
      <main class="container flex flex-col justify-center gap-14 min-h-screen">
        <!-- Breadcrumb -->
        <p class="text-sm text-gray-600 pt-4">Requests > book details</p>

        <div v-if="!bookDetails">LOADING</div>
        <div v-else>
          <div class="h-[calc(100vh-150px)] flex gap-10">
            <!-- Overview Section -->
            <div class="w-2/5 bg-white rounded-lg p-6 shadow-sm">
              <h2 class="text-lg mb-6">overview</h2>

              <!-- Profile Section -->
              <div class="flex gap-4 mb-6">
                <div class="shrink-0">
                  <img
                    class="h-14 w-14 rounded-full"
                    :src="bookDetails.student.profile_image"
                    alt="profile image"
                  />
                </div>
                <div class="w-full">
                  <div class="flex justify-between bg-gray-50 p-2 rounded mb-2">
                    <p class="font-medium">
                      {{ bookDetails.student.first_name }}
                      {{ bookDetails.student.last_name }}
                    </p>
                    <button class="text-blue-600 underline text-sm">
                      report
                    </button>
                  </div>
                </div>
              </div>

              <!-- Details -->
              <div class="space-y-4">
                <div class="flex items-center gap-2">
                  <span>Status:</span>
                  <span
                    class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm"
                  >
                    {{ bookDetails.status || 'pending' }}
                  </span>
                </div>

                <div class="flex items-center gap-2">
                  <span>Subject:</span>
                  <span
                    class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm"
                  >
                    {{ bookDetails.subject }}
                  </span>
                </div>

                <p>
                  mode of tutor: {{ bookDetails.learning_mode || 'online' }}
                </p>
                <p>
                  {{
                    bookDetails.learning_mode === 'Online'
                      ? 'Online Meeting Platform: ' +
                        bookDetails.online_meeting_platform
                      : 'Location: ' + bookDetails.location
                  }}
                </p>
                <p>Contact info: {{ bookDetails.contact_number }}</p>

                <!-- Date and Time -->
                <div v-if="bookDetails.messages?.length">
                  <p class="font-medium mb-2">Date & Time:</p>
                  <div
                    v-for="dateTime in bookDetails.messages[
                      bookDetails.messages.length - 1
                    ].dates"
                    :key="dateTime.id"
                    class="text-blue-600"
                  >
                    {{ formatDate(dateTime.start_time) }} -
                    {{ formatDate(dateTime.end_time) }}
                  </div>
                </div>
              </div>
            </div>

            <!-- Messages Section -->
            <div class="w-3/5 bg-white rounded-lg p-6 shadow-sm">
              <div v-if="!isNegotiating || seeMore">
                <h3>
                  {{ bookDetails.student.first_name }}
                  {{ bookDetails.student.last_name }}'s message
                </h3>
                <div class="space-y-4 outline">
                  <div
                    v-for="message in bookDetails.messages"
                    :key="message.id"
                  >
                    <div class="mb-2">
                      <label class="block text-sm font-medium mb-1"
                        >SUBJECT</label
                      >
                      <div class="p-2 bg-gray-50 rounded">
                        {{ message.title }}
                      </div>
                    </div>
                    <div>
                      <div class="p-2 bg-gray-50 rounded">
                        {{ message.message }}
                      </div>
                    </div>
                  </div>
                </div>
                <div v-show="isNegotiating">
                  <button @click="seeMore = !seeMore">hide</button>
                </div>
              </div>

              <div v-if="isNegotiating && !seeMore">
                <h3>
                  {{ bookDetails.student.first_name }}
                  {{ bookDetails.student.last_name }}'s message
                </h3>
                <div class="space-y-4 outline">
                  <button @click="seeMore = !seeMore">
                    see more of {{ bookDetails.student.first_name }}'s message
                  </button>
                </div>
              </div>

              <!-- IS NEGOTIATING MESSAGE AND CALENDAR -->
              <div v-if="isNegotiating">
                <p>your message:</p>
                <div class="flex">
                  <button @click="toggleCalendar" class="bg-green-300">
                    change date
                  </button>
                  <PopUpModal
                    :toggleModal="showCalendar"
                    :isDay="isDay"
                    @openValue="changeValueToFalse"
                    @mainButtonValue="handleMainButton"
                    @cancelButtonValue="handleCancelButton"
                  >
                    <template #modalTitle>
                      <p>Change Dates</p>
                    </template>

                    <template #mainContent>
                      <RescheduleCalendar
                        :tutorBookings="fetchedTutorBookings"
                        :tutorWorkDays="userData.work_days"
                        :studentBookings="fetchedStudentBookings"
                        @isDayValue="storeIsDayValue"
                        @selectedCellValue="storeSelectedCellDate"
                      />
                    </template>
                    <template #mainButton>
                      <p>Confirm</p>
                    </template>
                    <template #cancelButton>
                      <p>Cancel</p>
                    </template>
                  </PopUpModal>
                </div>

                <div class="border rounded p-2">
                  <label class="block text-gray-700">Message:</label>
                  <!-- v-model="bookingState.tutorTopic" -->

                  <input
                    class="w-full border-none outline-none mb-1"
                    v-model="negotiationTitle"
                    placeholder="Enter the topic that needs tutoring"
                  />
                  <!-- v-model="bookingState.tutorMessage" -->

                  <textarea
                    class="w-full border-none outline-none mt-1 h-24 resize-none"
                    v-model="negotiationMessage"
                    placeholder="Enter objectives, concerns, and further details of your inquiry"
                  ></textarea>
                </div>
              </div>
              <!-- IS NEGOTIATING MESSAGE AND CALENDAR -->

              <!-- BUTTONS -->
              <div class="flex justify-between w-full">
                <!-- NEGOTIATE -->
                <div v-if="bookDetails.messages.length === 1 && !isNegotiating">
                  <button @click="isNegotiating = true" class="outline">
                    negotiate
                  </button>
                </div>
                <!-- NEGOTIATE -->
                <div v-if="!isNegotiating" class="flex gap-4">
                  <button
                    @click="updateBookingStatus('Canceled')"
                    class="bg-red-300"
                  >
                    decline
                  </button>
                  <button
                    @click="updateBookingStatus('Ongoing')"
                    class="bg-green-300"
                  >
                    accept
                  </button>
                </div>

                <div v-if="isNegotiating" class="flex gap-4">
                  <button @click="isNegotiating = false" class="bg-red-300">
                    cancel
                  </button>
                  <button
                    @click="updateBookingStatus('Ongoing')"
                    class="bg-green-300"
                  >
                    submit
                  </button>
                </div>
              </div>
              <button @click="testg" class="bg-green-300">click me</button>
            </div>
            <!-- BUTTONS -->
          </div>
        </div>
      </main>
    </SideBar>
    <HelpButton />
  </main>
</template>

<script setup>
// import BookCalendar from '@/components/BookCalendar.vue'
import RescheduleCalendar from '@/components/TutorBookDetails/RescheduleCalendar.vue'
import PopUpModal from '@/components/Reusables/PopUpModal.vue'
import { ref, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import SideBar from '@/components/SideBar.vue'
import HelpButton from '@/components/HelpButton.vue'
import axiosInstance from '@/axiosInstance'

//TESTING GROUNDS
const parsedUserData = JSON.parse(localStorage.getItem('user_data') || '{}')
const userData = ref(parsedUserData)

const testg = () => {
  console.log(JSON.stringify(fetchedTutorBookings.value, null, 2))
  console.log(JSON.stringify(fetchedStudentBookings.value, null, 2))
}

const fetchedTutorBookings = ref([])
const fetchOngoingTutorBookings = async tutorId => {
  try {
    const response = await axiosInstance.get(
      `/api/ongoing-tutor-booking-dates/${tutorId}`,
    )
    fetchedTutorBookings.value = response.data.tutor_bookings
  } catch (err) {
    console.error('Error fetching tutor details:', err)
  }
}

const fetchedStudentBookings = ref([])
const fetchOngoingStudentBookings = async studentId => {
  try {
    const response = await axiosInstance.get(
      `/api/ongoing-student-booking-dates/${studentId}`,
    )
    fetchedStudentBookings.value = response.data.student_bookings
  } catch (err) {
    console.error('Error fetching tutor details:', err)
  }
}

//TESTING GROUNDS

const route = useRoute()
const router = useRouter()

// TESTING
const showCalendar = ref(false)

const toggleCalendar = () => {
  showCalendar.value = true
}
const changeValueToFalse = newValue => {
  console.log(newValue)
  showCalendar.value = newValue
}

const handleMainButton = () => {
  showCalendar.value = false
}

const handleCancelButton = () => {
  showCalendar.value = false
}



const seeMore = ref(false)

const negotiationTitle = ref('')
const negotiationMessage = ref('')

const isDay = ref(true)
const storeIsDayValue = isDayValue => {
  isDay.value = !isDayValue
}




// TESTING

const isNegotiating = ref(false)

const formatDate = date => {
  return new Intl.DateTimeFormat('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  }).format(new Date(date))
}

const updateBookingStatus = async status => {
  try {
    await axiosInstance.patch(
      `/api/update-student-booking/${route.params.bookId}`,
      {
        status: status,
      },
    )
    if (status === 'Ongoing') {
      router.push({ path: '/tutor/schedule' })
    } else {
      router.push({ path: '/tutor/requests' })
    }

    // bookDetails.value = response.data.book_details
  } catch (err) {
    console.error('Error fetching booking details:', err)
  }
}

const bookDetails = ref(null)

const fetchBookingDetails = async bookId => {
  try {
    const response = await axiosInstance.get(
      `/api/book-request-details/${bookId}`,
    )
    const bookData = response.data.book_details

    if (bookData.status === 'Ongoing') {
      router.push({ path: `/tutor/schedule/${bookId}` })
    } else {
      bookDetails.value = bookData
    }
  } catch (err) {
    console.error('Error fetching booking details:', err)
    router.push({ name: 'NotFound' }) // Redirect to 404 in case of error
  }
}

watch(
  () => bookDetails.value,
  newVal => {
    if (newVal) {
      fetchOngoingTutorBookings(userData.value.id)
      fetchOngoingStudentBookings(bookDetails.value.student.id)
    }
  },
)

onMounted(() => {
  const initialBookId = route.params.bookId
  if (initialBookId) {
    fetchBookingDetails(initialBookId)
  }
})
</script>
