<template>
  <main class="bg-blue-50">
    <SideBar>
      <main class="container p-5 mx-auto">
        <!-- Profile Header -->
        <div
          class="flex items-center justify-between p-4 bg-white rounded-lg shadow-md"
        >
          <div class="flex items-center gap-4">
            <img
              class="w-20 h-20 rounded-full"
              :src="userData.profile_image"
              alt="Profile Image"
            />
            <div class="">
              <h2 class="text-lg font-semibold">{{ userFullName }}</h2>
              <p>{{ userEmail }}</p>
            </div>
          </div>

          <div>
            <button
              class="px-4 py-2 mt-2 text-sm font-medium text-white bg-blue-500 rounded hover:bg-blue-600"
            >
              Edit profile
            </button>
          </div>
        </div>

        <!-- Profile Content -->
        <div class="flex mt-6 space-x-4">
          <!-- Subjects, Rating, and Availability -->
          <section class="w-1/3 p-4 bg-white rounded-lg shadow-md">
            <h3 class="font-semibold">Subjects:</h3>
            <div
              v-for="subject in userData.subjects"
              :key="subject.id"
              class="flex gap-2"
            >
              <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full">{{
                subject.name
              }}</span>
            </div>

            <h3 class="mt-4 font-semibold">Ratings:</h3>
            <StarRating :rating="averageRatings"></StarRating>
            <h3 class="mt-4 font-semibold">Availability:</h3>
            <div class="mb-6">
              <h3 class="font-medium mb-2">Days available:</h3>

              <div v-for="day in availableDays" :key="day" class="flex gap-2">
                <span
                  class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full"
                  >{{ day }}</span
                >
              </div>
            </div>
            <div class="mb-6">
              <h3 class="font-medium mb-2">Hours available:</h3>
              <p class="text-blue-600 font-medium">
                {{ userData.work_days.start_time }}-{{
                  userData.work_days.end_time
                }}
              </p>
            </div>

            <h3 class="mt-4 font-semibold">Rate:</h3>
            <p class="text-blue-500">P{{ userData.tutor_rate }}/Session</p>

            <h3 class="mt-4 font-semibold">Personal details:</h3>
            <ul class="mt-2 space-y-1 text-sm text-gray-700">
              <li>{{ formatDate(userData.birthdate) }}</li>
              <li>{{ userData.address }}</li>
              <li>{{ userData.contact_number }}</li>
            </ul>
          </section>

          <!-- Bio, Education, and Certification -->
          <section class="flex-1 space-y-4">
            <div class="p-4 bg-white rounded-lg shadow-md">
              <h3 class="font-semibold">BIO</h3>
              <p class="text-sm text-gray-700">
                {{ userData.biography }}
              </p>
            </div>

            <div class="p-4 bg-white rounded-lg shadow-md">
              <h3 class="font-semibold">Education</h3>
              <div
                v-for="school in userData.schools"
                :key="school.id"
                class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg border border-gray-200 transition-shadow"
              >
                <p class="text-lg font-semibold text-gray-900">
                  {{ school.name }}
                </p>
                <p class="text-sm text-gray-500 italic">{{ school.course }}</p>
                <p class="text-sm text-gray-600 mt-2">
                  {{ formatDate(school.start_date) }} -
                  {{
                    school.end_date ? formatDate(school.end_date) : 'Present'
                  }}
                </p>
              </div>
            </div>

            <div class="p-4 bg-white rounded-lg shadow-md">
              <h3 class="font-semibold">Certification</h3>
              <div
                v-for="certificate in userData.certificates"
                :key="certificate.id"
                class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg border border-gray-200 transition-shadow"
              >
                <p class="text-lg font-semibold text-gray-900">
                  {{ certificate.title }}
                </p>
                <p class="text-sm text-gray-500 italic">
                  {{ certificate.issuer }}
                </p>
                <p class="text-sm text-gray-600 mt-2">
                  {{ formatDate(certificate.date_issued) }}
                </p>
              </div>
            </div>
          </section>
        </div>
      </main>
    </SideBar>

    <HelpButton />
  </main>
</template>

<script setup>
import SideBar from '@/components/SideBar.vue'
import HelpButton from '@/components/HelpButton.vue'
import StarRating from '@/components/StarRating.vue'
import { ref, reactive, onMounted, watch, computed } from 'vue'
// import axiosInstance from '@/axiosInstance'

// const route = useRoute()
const userEmail = localStorage.getItem('user_email')
const userFullName = localStorage.getItem('user_full_name')
const getUserData = localStorage.getItem('user_data')
const userData = getUserData ? JSON.parse(getUserData) : {}
// const studentContactNumber = userData ? userData.contact_number : null

const averageRatings = computed(() => {
  const ratings = userData.ratings.map(rating => rating.rate)
  const total = ratings.reduce((sum, rate) => sum + rate, 0)
  return total / ratings.length
})

const availableDays = computed(() => {
  if (!userData.work_days || Object.keys(userData.work_days).length === 0) {
    return null
  }

  const daysOfWeek = [
    'monday',
    'tuesday',
    'wednesday',
    'thursday',
    'friday',
    'saturday',
    'sunday',
  ]

  return daysOfWeek
    .filter(day => userData.work_days[day])
    .map(day => day.charAt(0).toUpperCase() + day.slice(1))
})

const formatDate = date => {
  return new Intl.DateTimeFormat('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  }).format(new Date(date))
}
</script>
