<template>
  <main>
    <SideBar>
      <main
        class="container flex flex-col justify-center gap-14 min-h-screen bg-blue-50"
      >
        <div v-if="!bookDetails">LOADING</div>
        <div v-else>
          <div class="h-[calc(100vh-150px)] flex gap-10">
            <div class="bg-red-300 w-2/5 flex flex-col items-center">
              <div class="outline">OVERVIEW</div>
              <div class="w-full flex gap-8 outline">
                <div class="outline shrink-0">
                  <img
                    class="shrink-0 h-14 rounded-full"
                    :src="bookDetails.student.profile_image"
                    alt="profile image"
                  />
                </div>
                <div class="w-full">
                  <div class="flex justify-between bg-slate-100 outline">
                    <p>
                      {{ bookDetails.student.first_name }}
                      {{ bookDetails.student.last_name }}
                    </p>
                    <button class="underline">report</button>
                  </div>
                  <button class="bg-blue-300">view profile</button>
                </div>
              </div>
              <div class="outline">
                <p>{{ bookDetails.status }}</p>
                <p>{{ bookDetails.subject }}</p>
                <p>{{ bookDetails.learning_mode }}</p>
                <p>
                  {{
                    bookDetails.learning_mode === 'Online'
                      ? bookDetails.online_meeting_platform
                      : bookDetails.location
                  }}
                </p>
                <p>{{ bookDetails.contact_number }}</p>

                <!-- BOOK MESSAGES -->
                <div v-if="!bookDetails.messages.length">
                  <p>loading messages</p>
                </div>
                <div v-else>
                  <p>date and time</p>
                  <div
                    v-for="message in bookDetails.messages"
                    :key="message.id"
                  >
                    <div v-for="dateTime in message.dates" :key="dateTime.id">
                      <p>{{ dateTime.start_time }}</p>
                      <p>{{ dateTime.end_time }}</p>
                    </div>
                  </div>
                </div>
                <!-- BOOK MESSAGES -->
              </div>
            </div>
            <div class="bg-red-300 w-4/5">
              <div
                v-for="message in bookDetails.messages"
                :key="message.id"
                class="flex flex-col gap-5"
              >
                <div class="outline">
                  {{ message.title }}
                </div>
                <div class="outline">
                  {{ message.message }}
                </div>
              </div>
            </div>
          </div>
          <!-- {{ bookDetails }} -->
        </div>
      </main>
    </SideBar>
    <HelpButton />
  </main>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import SideBar from '@/components/SideBar.vue'
import HelpButton from '@/components/HelpButton.vue'
import axiosInstance from '@/axiosInstance'

// const router = useRouter()
const route = useRoute()

const bookDetails = ref(null)

const fetchBookingDetails = async bookId => {
  try {
    const response = await axiosInstance.get(
      `/api/book-request-details/${bookId}`,
    )
    bookDetails.value = response.data.book_details
  } catch (err) {
    console.error('Error fetching tutor details:', err)
  }
}

onMounted(() => {
  const initialBookId = route.params.bookId
  if (initialBookId) {
    fetchBookingDetails(initialBookId)
  }
})
</script>
