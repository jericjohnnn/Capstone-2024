<template>
  <div class="w-full shadow-sm">
    <div class="space-y-6">
      <div
        v-for="(message, index) in bookDetails.messages"
        :key="message.id"
        class="py-3 rounded-lg border"
        :class="
          index % 2 === 0
            ? 'bg-blue-100 border-blue-300'
            : 'bg-slate-100 border-slate-300'
        "
      >
        <h3 class="text-base text-center font-medium">
          {{
            index % 2 === 0
              ? 'Your message'
              : bookDetails.tutor.first_name +
                ' ' +
                bookDetails.tutor.last_name +
                "'s message"
          }}
        </h3>
        <p class="pl-2 text-xs">Title:</p>
        <div class="pb-2 px-2">
          <div
            class="p-2 border rounded min-h-20"
            :class="
              index % 2 === 0
                ? 'border-blue-400 bg-white/40'
                : 'border-slate-400 bg-white/40'
            "
          >
            <p>{{ message.title }}</p>
          </div>
        </div>
        <p class="pl-2 text-xs">Message:</p>
        <div class="pb-2 px-2">
          <div
            class="p-2 border rounded min-h-40"
            :class="
              index % 2 === 0
                ? 'border-blue-400 bg-white/40'
                : 'border-slate-400 bg-white/40'
            "
          >
            {{ message.message }}
          </div>
        </div>
      </div>
    </div>

    <!-- IS NEGOTIATING MESSAGE AND CALENDAR -->
    <div v-if="isNegotiating" class=" pt-4" ref="negotiationForm">
      <div class="flex justify-between items-center">
        <p>Your message:</p>
        <button @click="toggleCalendar" class="p-2 bg-blue-600 text-white rounded-md">
          Change dates
        </button>
      </div>
      <div class="flex">
        <div class="flex w-full flex-wrap gap-2">
        <!-- zz -->
          <div
            v-if="pendingBookingDatesPlaceholder.length === 0"
            class="flex justify-center  w-full"
          >
            <p class="text-slate-400 py-4">No dates selected</p>
          </div>
          <div v-else class="flex flex-wrap gap-2 justify-center w-full py-2">
            <div v-for="date in pendingBookingDatesPlaceholder" :key="date.id" class="">
              <div
                class="bg-blue-500 text-white text-sm px-3 py-2 grid grid-cols-[auto,1fr] gap-1 rounded-lg"
              >
                <div class="font-semibold text-sm">
                  {{ formatDate(date.start) }}
                </div>
                <button
                  @click="removeDate(date.id)"
                  class="font-bold col-span-1 rounded-full bg-red-400"
                >
                  X
                </button>

                <div class="text-sm col-span-2">
                  {{
                    formatTo12Hour(extractTimeFromDateTimeString(date.start))
                  }}
                  to
                  {{ formatTo12Hour(extractTimeFromDateTimeString(date.end)) }}
                </div>
              </div>
            </div>
          </div>
          <!-- zz -->

          <!-- <div
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
          </div> -->
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
            <div v-if="!tutorBookings && !studentBookings && !tutorWorkDays">
              <LoaderSpinner />
            </div>
            <div v-else>
              <BookCalendar
                :tutorBookings="tutorBookings"
                :tutorWorkDays="tutorWorkDays"
                :studentBookings="studentBookings"
                @update:added-schedules="storePendingBookingDates"
              />
            </div>
          </template>
          <template #mainButton>
            <p>Confirm</p>
          </template>
          <template #cancelButton>
            <p>Cancel</p>
          </template>
        </PopUpModal>
      </div>

      <div class="border rounded p-2 ">
        <!-- v-model="bookingState.tutorTopic" -->
        <input
          class="w-full border outline-none mb-1"
          v-model="negotiationTitle"
          placeholder="Enter the topic that needs tutoring"
        />
        <!-- v-model="bookingState.tutorMessage" -->

        <textarea
          class="w-full border outline-none mt-1 h-24 resize"
          v-model="negotiationMessage"
          placeholder="Enter objectives, concerns, and further details of your inquiry"
        ></textarea>
      </div>
    </div>
    <!-- IS NEGOTIATING MESSAGE AND CALENDAR -->

    <!-- BUTTONS -->
    <div
      :class="[
        'flex justify-between rounded-lg backdrop-blur-sm w-full z-30 bg-blue-50 border border-white dark:bg-neutral-900 p-3 border-t dark:border-neutral-700',
        { 'sticky md:relative': !isKeyboardVisible },
        bookDetails.status === 'Completed' ? 'hidden' : ''
      ]"
    >
      <!-- NEGOTIATE -->
      <div
        v-if="
          bookDetails.messages.length === 3 || bookDetails.messages.length === 1
        "
        class="w-full text-center text-gray-600"
      >
        <p>Waiting for tutor to respond.</p>
        <div>{{ bookDetails.status }}</div>
      </div>

      <!-- NEGOTIATE -->
      <div
        v-if="!isNegotiating && bookDetails.messages.length === 2"
        class="flex justify-between w-full gap-4"
      >
        <button
          @click="handleNegotiateClick"
          class="pr-2 text-blue-600 underline"
        >
          negotiate
        </button>
        <div class="space-x-4">
          <button
            @click="updateBookingStatus('Canceled')"
            class="p-2 border text-blue-600 border-blue-600 rounded-md"
          >
            decline
          </button>
          <button
            @click="updateBookingStatus('Ongoing')"
            class="p-2 bg-blue-600 text-white rounded-md"
          >
            accept
          </button>
        </div>
      </div>

      <div
        v-if="isNegotiating"
        class="flex  justify-center w-full gap-4"
      >
        <button
          @click="handleCancelNegotiation"
          class="p-2 border text-slate-600 border-slate-600 rounded-md"
        >
          cancel
        </button>
        <button
          @click="submitNegotiation"
          class="p-2 bg-blue-600 text-white rounded-md"
        >
          submit
        </button>
      </div>
    </div>
  </div>
</template>
<script setup>
import PopUpModal from '@/components/reusables/PopUpModal.vue'
import { ref, onMounted, onBeforeUnmount, nextTick } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axiosInstance from '@/axiosInstance'
import BookCalendar from '@/components/shared/calendar/BookCalendar.vue'
import LoaderSpinner from '@/components/Reusables/LoaderSpinner.vue'
import { formatDate, formatTo12Hour, extractTimeFromDateTimeString } from '@/utils/dateTime'

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

const isKeyboardVisible = ref(false)

const handleResize = () => {
  isKeyboardVisible.value = window.innerHeight < window.outerHeight - 100
}

onMounted(() => {
  window.addEventListener('resize', handleResize)
  handleResize()
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', handleResize)
})

const negotiationForm = ref(null)

const handleNegotiateClick = () => {
  isNegotiating.value = true
  // Wait for DOM update before scrolling
  nextTick(() => {
    negotiationForm.value?.scrollIntoView({
      behavior: 'smooth',
      block: 'center',
    })
  })
}
</script>

<style scoped>
.sticky {
  position: sticky;
  bottom: 0;
}
</style>
