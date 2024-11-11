<template>
  <div>
    <vue-cal
      click-to-navigate
      active-view="month"
      :disable-views="['week']"
      :hide-weekdays="hiddenWeekDays"
      :time-from="0 * 60"
      :time-to="25 * 60"
      :events="events"
      :on-event-click="goToBookingDetails"
      class="vuecal--full-height-delete"
      style="height: 500px"
    >
      <!-- <template #title="{ view }">
        🎉
        <span class="" v-if="view.id === 'month'">{{
          view.startDate.format("MMMM YYYY")
        }}</span>
        <span class="" v-if="view.id === 'day'">{{
          view.endDate.format("dddd | MMMM D")
        }}</span>
        🎉
      </template> -->
      <template #event="{ event }">
        <div class="vuecal__event-title" v-html="event.title" />
        <span>{{ event.start.formatTime('hh:mm{am}') }}</span>
        <span>{{ event.end.formatTime('hh:mm{am}') }}</span>
      </template>
    </vue-cal>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axiosInstance from '@/axiosInstance'
import VueCal from 'vue-cal'
import 'vue-cal/dist/vuecal.css'

const router = useRouter()
// const route = useRoute()


const props = defineProps({
  routePath: {
    type: String,
    required: true
  }
})

const goToBookingDetails = bookDetails => {
  router.push({
    path: `${props.routePath}/${bookDetails.booking_id}`
  })
}

const events = ref([])


const parsedUserData = JSON.parse(localStorage.getItem('user_data') || '{}')
const userData = ref(parsedUserData)

const hiddenWeekDays = computed(() => {
  if (!userData.value || !userData.value.work_days) {
    return []
  }

  const dayToNumber = {
    monday: 1,
    tuesday: 2,
    wednesday: 3,
    thursday: 4,
    friday: 5,
    saturday: 6,
    sunday: 7,
  }

  return Object.keys(userData.value.work_days)
    .filter(day => !userData.value.work_days[day])
    .map(day => dayToNumber[day])
})

const formatRawDateTime = dateString => {
  // Format to 'YYYY-MM-DD HH:mm:ss'
  return new Date(dateString).toISOString().slice(0, 19).replace('T', ' ')
}

const fetchTutorSchedules = async () => {
  try {
    const response = await axiosInstance.get(`/api/booking-schedules`)
    const { bookings } = response.data

    events.value = bookings.flatMap(booking =>
      booking.booking_dates.map(date => ({
        id: date.id,
        booking_id: booking.booking_id,
        start: formatRawDateTime(date.start_time),
        end: formatRawDateTime(date.end_time),
        title: booking.subject,
        class: 'ongoingBookings',
      })),
    )
  } catch (err) {
    console.error('Error fetching tutor details:', err)
  }
}

onMounted(() => {
  fetchTutorSchedules()
})
</script>

<style>
.vuecal__event.ongoingBookings {
  background-color: rgba(250, 190, 61, 0.902);
  border: 1px solid rgba(255, 253, 248, 0.902);
  color: hsla(0, 0%, 100%, 0.902);
  font-size: 0.75em;
}

.vuecal__cell--before-min {
  color: #b6d6c7;
}

.vuecal__cell--after-max {
  color: #00f0f0;
}
</style>
