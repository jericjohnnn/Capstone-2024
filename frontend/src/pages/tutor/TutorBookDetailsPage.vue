<template>
  <main class="bg-blue-50">
    <SideBar>
      <main class="container flex flex-col justify-center gap-14 min-h-screen">
        <!-- Breadcrumb -->
        <BreadCrumb
          :breadcrumbs="[
            { label: 'Requests', route: '/tutor/requests' },
            { label: 'Book Details', route: '/tutor/book-details' },
          ]"
        />
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
            <BookMessages
              :bookDetailsProps="bookDetails"
              :tutorBookings="fetchedTutorBookings"
              :tutorWorkDays="userData.work_days"
              :studentBookings="fetchedStudentBookings"
            ></BookMessages>
            <!-- BUTTONS -->
          </div>
        </div>
      </main>
    </SideBar>
    <HelpButton />
  </main>
</template>

<script setup>
import BreadCrumb from '@/components/BreadCrumb.vue'
import BookMessages from '@/components/TutorBookDetails/BookMessages.vue'
import { ref, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import SideBar from '@/components/SideBar.vue'
import HelpButton from '@/components/HelpButton.vue'
import axiosInstance from '@/axiosInstance'

//HELPER FUNCTIONS
const formatDate = date => {
  return new Intl.DateTimeFormat('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  }).format(new Date(date))
}

//HELPER FUNCTIONS
const parsedUserData = JSON.parse(localStorage.getItem('user_data') || '{}')
const userData = ref(parsedUserData)

const route = useRoute()
const router = useRouter()

const bookDetails = ref(null)
const fetchedTutorBookings = ref([])
const fetchedStudentBookings = ref([])

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
