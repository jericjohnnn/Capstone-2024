<template>
  <div class="outline flex flex-col bg-white rounded-xl shadow-sm">
    <!-- Header Section with Blue Background -->
    <div class="bg-blue-600 p-4 rounded-t-xl flex justify-between items-center">
      <div class="flex items-center gap-3">
        <img
          alt="Tutor avatar"
          :src="tutor.profile_image"
          class="w-16 h-16 shrink-0 rounded-full"
        />
        <div class="text-white">
          <h2 class="font-medium text-lg">
            {{ tutor.first_name }} {{ tutor.last_name }}
          </h2>
          <p class="text-blue-100">{{ tutor.address }}</p>
        </div>
      </div>
      <div class="flex flex-col">
        <button
          @click="goToBook"
          class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-400"
        >
          BOOK
        </button>
        <p>{{ tutor.id }}</p>
        <a href="#">report</a>
      </div>
    </div>

    <!-- Scrollable Content -->
    <div
      class="h-[calc(100vh-350px)] overflow-y-auto p-4 [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300"
    >
      <!-- Bio Section -->
      <p class="text-gray-600 mb-6">
        {{ tutor.biography }}
      </p>

      <div class="flex">
        <div class="bg-red-400">
          <!-- Subjects Section -->
          <div class="mb-6">
            <h3 class="font-medium mb-2">Subjects offered:</h3>
            <div
              v-for="subject in tutor.subjects"
              :key="subject.id"
              class="flex gap-2"
            >
              <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full">{{
                subject.name
              }}</span>
            </div>
          </div>

          <div class="mb-6">
            <h3 class="font-medium mb-2">Rate:</h3>
            <p>{{ tutor.tutor_rate }}</p>
          </div>
        </div>

        <!-- Availability Section -->
        <div v-if="!availableDays" class="text-gray-600">
          <p>No work days preference yet</p>
        </div>

        <div v-else class="bg-blue-500">
          <div class="mb-6">
            <h3 class="font-medium mb-2">Days available:</h3>

            <div v-for="day in availableDays" :key="day" class="flex gap-2">
              <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full">{{
                day
              }}</span>
            </div>
          </div>

          <div class="mb-6">
            <h3 class="font-medium mb-2">Hours available:</h3>
            <p class="text-blue-600 font-medium">
              {{ tutor.work_days.start_time }}
              {{ tutor.work_days.end_time }}
            </p>
          </div>
        </div>
      </div>

      <!-- Education Section -->
      <div>
        <h3 class="text-xl font-bold text-gray-800 mb-6">Education</h3>

        <div
          v-if="!tutor.schools || tutor.schools.length === 0"
          class="text-gray-600"
        >
          <p>No education information available.</p>
        </div>

        <div v-else class="space-y-6">
          <div
            v-for="school in tutor.schools"
            :key="school.id"
            class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg border border-gray-200 transition-shadow"
          >
            <p class="text-lg font-semibold text-gray-900">{{ school.name }}</p>
            <p class="text-sm text-gray-500 italic">{{ school.course }}</p>
            <p class="text-sm text-gray-600 mt-2">
              {{ formatDate(school.start_date) }} -
              {{ school.end_date ? formatDate(school.end_date) : 'Present' }}
            </p>
          </div>
        </div>
      </div>

      <!-- Certificates Section -->
      <div>
        <h3 class="text-xl font-bold text-gray-800 mb-6">Certifications</h3>

        <div
          v-if="!tutor.certificates || tutor.certificates.length === 0"
          class="text-gray-600"
        >
          <p>No certificates information available.</p>
        </div>

        <div v-else class="space-y-6">
          <div
            v-for="certificate in tutor.certificates"
            :key="certificate.id"
            class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg border border-gray-200 transition-shadow"
          >
            <p class="text-lg font-semibold text-gray-900">
              {{ certificate.title }}
            </p>
            <p class="text-sm text-gray-500 italic">{{ certificate.issuer }}</p>
            <p class="text-sm text-gray-600 mt-2">
              {{ formatDate(certificate.date_issued) }}
            </p>
          </div>
        </div>
      </div>

      <!-- Certificates Section -->
      <div>
        <StarRating :rating="averageRatings"></StarRating>
        <h3 class="text-xl font-bold text-gray-800 mb-6">Ratings</h3>

        <div
          v-if="!tutor.ratings || tutor.ratings.length === 0"
          class="text-gray-600"
        >
          <p>No ratings information available.</p>
        </div>

        <div v-else class="space-y-6">
          <RatingsCarousel
            class="w-full"
            :ratingComments="ratingComments"
          ></RatingsCarousel>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import StarRating from './StarRating.vue'
import RatingsCarousel from './RatingsCarousel.vue'
import { computed } from 'vue'
import { useRouter } from 'vue-router';

const router = useRouter();

const props = defineProps({
  tutor: {
    type: Object,
    required: true,
  },
})

function goToBook() {
  router.push({
    name: 'StudentBook',
    params: { tutorId: props.tutor.id },
  });
}

const availableDays = computed(() => {
  if (
    !props.tutor.work_days ||
    Object.keys(props.tutor.work_days).length === 0
  ) {
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
    .filter(day => props.tutor.work_days[day])
    .map(day => day.charAt(0).toUpperCase() + day.slice(1))
})

const averageRatings = computed(() => {
  const ratings = props.tutor.ratings.map(rating => rating.rate)
  const total = ratings.reduce((sum, rate) => sum + rate, 0)
  return total / ratings.length
})

const ratingComments = computed(() => {
  const ratingsWithComments = props.tutor.ratings.filter(
    rating => !!rating.comment,
  )
  return ratingsWithComments
})

const formatDate = date => {
  return new Intl.DateTimeFormat('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  }).format(new Date(date))
}

// const schools = computed(() => {
//   if (!props.tutor.schools || props.tutor.schools.length === 0) {
//     return null;
//   }
//   return props.tutor.schools;
// });
</script>
