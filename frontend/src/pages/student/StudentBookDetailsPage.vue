<template>
  <main class="bg-blue-50">
    <SideBar>
      <main class="container grid grid-rows-[auto,auto,1fr] grid-cols-1 md:grid-rows-[auto,1fr] md:grid-cols-5 py-5 gap-4 min-h-screen">
        <!-- Breadcrumb -->
        <div class="col-span-1 md:col-span-5">
          <BreadCrumb
            :breadcrumbs="[
              { label: 'Requests', route: '/student/requests' },
              { label: 'Book Details', route: '/student/book-details' },
            ]"
          />
        </div>

        <div v-if="!bookDetails" class="flex min-h-40 justify-center items-center md:h-full">
          <LoaderSpinner />
        </div>
        <div v-else>
          <!-- Overview Section -->
          <div class="md:row-span-1 md:col-span-2 bg-white rounded-lg py-3 md:overflow-scroll shadow-sm">
            <h2 class="text-xl font-medium text-center">Overview</h2>
            <div class="flex flex-col gap-4 px-2 md:px-5 py-4">
              <!-- Profile Section -->
              <div class="flex items-center gap-2">
                <div class="shrink-0">
                  <img
                    class="h-14 w-14 rounded-full"
                    :src="bookDetails.tutor.profile_image"
                    alt="profile image"
                  />
                </div>
                <div class="w-full">
                  <div class="flex justify-between rounded">
                    <p class="font-medium text-lg capitalize">
                      {{ bookDetails.tutor.first_name }}
                      {{ bookDetails.tutor.last_name }}
                    </p>
                    <button class="border-2 border-blue-600 text-blue-600 rounded-md px-2 py-1 text-sm">
                      Report
                    </button>
                  </div>
                </div>
              </div>

              <!-- Details -->
              <div class="flex flex-col gap-3">
                <!-- Status -->
                <div class="flex items-center gap-2">
                  <h2 class="font-medium w-full">Status:</h2>
                  <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm text-center w-full">
                    {{ bookDetails.status || 'pending' }}
                  </span>
                </div>

                <!-- Subject -->
                <div class="flex items-center gap-2">
                  <h2 class="font-medium w-full">Subject:</h2>
                  <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm w-full text-center">
                    {{ bookDetails.subject }}
                  </span>
                </div>

                <!-- Learning Mode -->
                <div class="flex items-center gap-2">
                  <h2 class="font-medium w-full">Learning Preference:</h2>
                  <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm w-full text-center">
                    {{ bookDetails.learning_mode || 'online' }}
                  </span>
                </div>

                <!-- Platform/Location -->
                <div class="flex items-center gap-2">
                  <h2 class="font-medium w-full shrink">
                    {{ bookDetails.learning_mode === 'Online' ? 'Online Meeting Platform:' : 'Location:' }}
                  </h2>
                  <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full w-full text-sm text-center">
                    {{ bookDetails.learning_mode === 'Online' ? bookDetails.online_meeting_platform : bookDetails.location }}
                  </span>
                </div>

                <!-- Contact -->
                <div class="flex items-center gap-2">
                  <h2 class="font-medium w-full">Contact Info:</h2>
                  <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm w-full text-center">
                    {{ bookDetails.contact_number }}
                  </span>
                </div>

                <!-- Date and Time -->
                <div v-if="bookDetails.messages?.length">
                  <h2 class="font-medium w-full mb-2">Date & Time:</h2>
                  <div
                    v-for="dateTime in bookDetails.messages[bookDetails.messages.length - 1].dates"
                    :key="dateTime.id"
                    class="text-blue-600 w-full"
                  >
                    {{ formatDate(dateTime.start_time) }}
                    {{ formatTo12Hour(extractTimeFromISO(dateTime.start_time)) }} -
                    {{ formatTo12Hour(extractTimeFromISO(dateTime.end_time)) }}
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Messages Section -->
          <div class="md:row-span-1 md:col-span-3 md:max-h-[calc(100vh-4.8rem)] md:overflow-scroll bg-white rounded-lg p-3 shadow-sm">
            <StudentBookMessages
              :bookDetailsProps="bookDetails"
              :tutorBookings="fetchedTutorBookings"
              :tutorWorkDays="tutorWorkDays"
              :studentBookings="fetchedStudentBookings"
            />
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
import { formatDate, extractTimeFromISO, formatTo12Hour } from '@/utils/dateTime'

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
    fetchTutorDetails(bookData.tutor_id)
  } catch (err) {
    console.error('Error fetching booking details:', err)
    router.push({ name: 'NotFound' }) // Redirect to 404 in case of error
  }
}

const tutorWorkDays = ref({})
const fetchTutorDetails = async tutorId => {
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
