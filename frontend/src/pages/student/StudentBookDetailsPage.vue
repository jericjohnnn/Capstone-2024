<template>
  <main class="bg-blue-50">
    <SideBar>
      <main class="container flex flex-col justify-center gap-14 min-h-screen">
        <!-- Breadcrumb -->
        <BreadCrumb
          :breadcrumbs="[
            { label: 'Requests', route: '/student/requests' },
            { label: 'Book Details', route: '/student/book-details' },
          ]"
        />

        <div v-if="!bookDetails">LOADING</div>
        <div v-else>
          <div class="h-[calc(100vh-150px)] flex gap-10">
            <!-- Overview Section -->
            <div class="w-2/5 bg-blue-200 rounded-lg p-6 shadow-sm">
              <h2 class="text-lg mb-6">Overview</h2>

              <!-- Profile Section -->
              <div class="flex gap-4 mb-6">
                <div class="shrink-0">
                  <img
                    class="h-14 w-14 rounded-full"
                    :src="bookDetails.tutor.profile_image"
                    alt="profile image"
                  />
                </div>
                <div class="w-full flex items-center">
                  <div class="flex flex-row justify-between w-full">
                    <p class="font-medium capitalize">
                      {{ bookDetails.tutor.first_name }}
                      {{ bookDetails.tutor.last_name }}
                    </p>
                    <button
                      class="text-red-600 border font-medium rounded-md border-red-600 px-4 py-1 hover:text-red-400 text-sm"
                    >
                      Report
                    </button>
                  </div>
                </div>
              </div>

              <!-- Details -->
              <div class="space-y-4">
                <div class="flex items-center">
                  <span class="text-sm">Status:</span>
                  <span
                    class="text-green-500 px-3 font-medium rounded-full text-md"
                  >
                    {{ bookDetails.status || 'pending' }}
                  </span>
                </div>

                <div class="flex items-center gap-2">
                  <span class="text-sm">Subject:</span>
                  <span
                    class="flex justify-center py-1 px-3 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-300"
                  >
                    {{ bookDetails.subject }}
                  </span>
                </div>

                <p>
                  <span class="text-sm">Mode of tutor:</span>
                  {{ bookDetails.learning_mode || 'online' }}
                </p>
                <p>
                  <span v-if="bookDetails.learning_mode === 'Online'">
                    Online Meeting Platform:
                    {{ bookDetails.online_meeting_platform }}
                  </span>
                  <span v-else>
                    <span class="text-sm">Location:</span>
                    {{ bookDetails.location }}
                  </span>
                </p>

                <p>
                  <span class="text-sm">Contact info:</span>
                  {{ bookDetails.contact_number }}
                </p>

                <!-- Date and Time -->
                <div v-if="bookDetails.messages?.length">
                  <p class="text-sm mb-2">Date & Time:</p>
                  <div
                    v-for="dateTime in bookDetails.messages[
                      bookDetails.messages.length - 1
                    ].dates"
                    :key="dateTime.id"
                    class=""
                  >
                    {{ formatDate(dateTime.start_time) }} -
                    {{ formatDate(dateTime.end_time) }}
                  </div>
                </div>
              </div>
            </div>

            <!-- Messages Section -->
            <StudentBookMessages
              :bookDetailsProps="bookDetails"
              :tutorBookings="fetchedTutorBookings"
              :tutorWorkDays="tutorWorkDays"
              :studentBookings="fetchedStudentBookings"
            />
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
import { ref, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import SideBar from '@/components/SideBar.vue'
import HelpButton from '@/components/HelpButton.vue'
import axiosInstance from '@/axiosInstance'
import StudentBookMessages from '@/components/student/StudentBookDetails/StudentBookMessages.vue'
import { formatDate } from '@/utils/dateTime'

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
      `/api/student-book-details/${bookId}`,
    )
    const bookData = response.data.book_details

    if (bookData.status === 'Ongoing') {
      router.push({ path: `/student/schedule/${bookId}` })
    } else {
      bookDetails.value = bookData
    }
    fetchTutorWorkDays(bookData.tutor_id)
  } catch (err) {
    console.error('Error fetching booking details:', err)
    router.push({ name: 'NotFound' }) // Redirect to 404 in case of error
  }
}

const tutorWorkDays = ref({})
const fetchTutorWorkDays = async tutorId => {
  try {
    const response = await axiosInstance.get(`/api/tutor-detail/${tutorId}`)
    const tutorData = response.data.tutor

    tutorWorkDays.value = tutorData.work_days
  } catch (err) {
    console.error('Error fetching booking details:', err)
    router.push({ name: 'NotFound' }) // Redirect to 404 in case of error
  }
}

watch(
  () => bookDetails.value,
  newVal => {
    if (newVal) {
      fetchOngoingTutorBookings(bookDetails.value.tutor_id)
      fetchOngoingStudentBookings(bookDetails.value.student_id)
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
