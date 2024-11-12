<template>
  <div class="w-3/5 bg-white rounded-lg p-6 shadow-sm overflow-scroll">
    <div class="space-y-4">
      <div v-for="(message, index) in bookDetails.messages" :key="message.id">
        <div class="mb-2">
          <h3>
            {{
              index % 2 === 0
                ? bookDetails.student.first_name +
                  ' ' +
                  bookDetails.student.last_name +
                  's Message'
                : 'Your Message'
            }}
          </h3>
          <label class="block text-sm font-medium mb-1">SUBJECT</label>
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

    <!-- IS NEGOTIATING MESSAGE AND CALENDAR -->
    <div v-if="isNegotiating">
      <p>your message:</p>
      <div class="flex">
        <button @click="toggleCalendar" class="bg-green-300">
          change date
        </button>
        <div
          v-for="schedule in pendingBookingDatesPlaceholder"
          :key="schedule.id"
          class="mb-2"
        >
          <div class="bg-red-500 outline p-2 flex flex-col text-white">
            <div class="font-semibold">
              {{ new Date(schedule.start).format('MMMM-DD-YYYY') }}
            </div>
            <div>
              {{ new Date(schedule.start).formatTime('hh:mm{am}') }}
              to
              {{ new Date(schedule.end).formatTime('hh:mm{am}') }}
            </div>
          </div>
        </div>
        <PopUpModal
          :toggleModal="showCalendar"
          @openValue="changeValueToFalse"
          @mainButtonValue="handleMainButton"
          @cancelButtonValue="handleCancelButton"
        >
          <template #modalTitle>
            <p>Change Dates</p>
          </template>

          <template #mainContent>
            <RescheduleCalendar
              :tutorBookings="tutorBookings"
              :tutorWorkDays="tutorWorkDays"
              :studentBookings="studentBookings"
              @update:added-schedules="storePendingBookingDates"
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
      <div v-if="bookDetails.messages.length === 2">
        <p>waiting for student negotiation</p>
      </div>
      <!-- NEGOTIATE -->
      <div v-if="!isNegotiating && bookDetails.messages.length !== 2" class="flex gap-4">
        <div v-if="bookDetails.messages.length === 1">
          <button @click="isNegotiating = true" class="outline">
            negotiate
          </button>
        </div>
        <button @click="updateBookingStatus('Canceled')" class="bg-red-300">
          decline
        </button>
        <button @click="updateBookingStatus('Ongoing')" class="bg-green-300">
          accept
        </button>
      </div>

      <div v-if="isNegotiating" class="flex gap-4">
        <button @click="handleCancelNegotiation" class="bg-red-300">
          cancel
        </button>
        <button @click="submitNegotiation" class="bg-green-300">submit</button>
      </div>
    </div>
  </div>
</template>
<script setup>
import RescheduleCalendar from '@/components/shared/calendar/RescheduleCalendar.vue'
import PopUpModal from '../reusables/PopUpModal.vue'
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axiosInstance from '@/axiosInstance'

const props = defineProps({
  bookDetailsProps: {
    type: Object,
    default: () => {},
  },
  tutorBookings: {
    type: Array,
    default: () => [],
  },
  tutorWorkDays: {
    type: Object,
    default: () => {},
  },
  studentBookings: {
    type: Array,
    default: () => [],
  },
})

//TESTING GROUNDS

const bookDetails = ref(props.bookDetailsProps)

const pendingBookingDates = ref([])
const storePendingBookingDates = bookingDates => {
  pendingBookingDates.value = bookingDates
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
  showCalendar.value = newValue
}

const handleMainButton = () => {
  pendingBookingDatesPlaceholder.value = pendingBookingDates.value
  showCalendar.value = false
}

const pendingBookingDatesPlaceholder = ref(pendingBookingDates.value)
const handleCancelButton = () => {
  pendingBookingDates.value = []
  showCalendar.value = false
}

const negotiationTitle = ref('')
const negotiationMessage = ref('')

// TESTING

const isNegotiating = ref(false)
const handleCancelNegotiation = () => {
  negotiationTitle.value = ''
  negotiationMessage.value = ''
  pendingBookingDatesPlaceholder.value = []
  isNegotiating.value = false
}

const submitNegotiation = async () => {
  const startAndEndArray = pendingBookingDatesPlaceholder.value.map(item => ({
    start: item.start,
    end: item.end,
  }))

  const bookRequest = {
    message_title: negotiationTitle.value,
    message_content: negotiationMessage.value,
    selected_date_times: startAndEndArray,
  }

  try {
    const response = await axiosInstance.post(
      `api/negotiate-booking/${route.params.bookId}`,
      bookRequest,
    )
    bookDetails.value = response.data.book_details
    isNegotiating.value = false
    console.log(response)
  } catch (error) {
    console.error('Error submitting form:', error)
    alert('There was an error submitting the form.')
  }
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
</script>
