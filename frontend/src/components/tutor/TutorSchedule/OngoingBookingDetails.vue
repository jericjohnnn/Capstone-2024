<template>
  <main class="bg-blue-50">
    <SideBar>
      <main class="container flex flex-col justify-center gap-14 min-h-screen">
        <!-- Breadcrumb -->
        <BreadCrumb
          :breadcrumbs="[
            { label: 'Schedule', route: '/tutor/schedule' },
            { label: 'Booking Details', route: '' }
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
                      {{ bookDetails.student.last_name }}, 25
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
              <div>
                <button
                  :disabled="isExpired"
                  @click="goToSchedules"
                  class="bg-blue-400"
                >
                  mark as complete
                </button>
              </div>
            </div>

            <!-- Messages Section -->
            <div class="w-3/5 bg-white rounded-lg p-6 shadow-sm">
              <h3>your message</h3>
              <div class="space-y-4 outline">
                <div v-for="message in bookDetails.messages" :key="message.id">
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
            </div>
          </div>
        </div>
      </main>
    </SideBar>
    <HelpButton />
  </main>
</template>

<script setup>
import BreadCrumb from '@/components/BreadCrumb.vue'
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import SideBar from '@/components/SideBar.vue'
import HelpButton from '@/components/HelpButton.vue'
import axiosInstance from '@/axiosInstance'
import { formatDate } from '@/utils/dateTime'

const route = useRoute()

// check booking if its expired
const isExpired = ref(true)

const checkIfExpired = () => {
  const dates = bookDetails.value.messages[bookDetails.value.messages.length - 1].dates

  const latestEndTime = dates.reduce((latest, date) => {
    const currentEndTime = new Date(date.end_time)
    return currentEndTime > latest ? currentEndTime : latest
  }, new Date(dates[0].end_time))

  const currentDate = new Date()

  if(latestEndTime < currentDate){
    isExpired.value = !isExpired.value
  }
}
//

const bookDetails = ref(null)

const fetchBookingDetails = async bookId => {
  try {
    const response = await axiosInstance.get(
      `/api/book-request-details/${bookId}`,
    )
    bookDetails.value = response.data.book_details
    checkIfExpired()
  } catch (err) {
    console.error('Error fetching booking details:', err)
  }
}

onMounted(() => {
  const initialBookId = route.params.bookId
  if (initialBookId) {
    fetchBookingDetails(initialBookId)
  }
})
</script>
<style>
button:disabled {
  background-color: #d3d3d3;
  color: #888888;
  cursor: not-allowed;
  opacity: 0.6;
  pointer-events: none;
}

button:disabled:hover {
  background-color: #d3d3d3;
  color: #888888;
}
</style>
