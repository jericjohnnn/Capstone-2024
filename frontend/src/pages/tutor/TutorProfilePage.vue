<template>
  <main class="bg-blue-50">
    <SideBar>
      <main class="container p-5 mx-auto">
        <!-- Profile Header -->
          <TutorProfileHeader></TutorProfileHeader>

        <!-- Profile Content -->
        <div class="flex mt-6 space-x-4">
          <!-- Subjects, Rating, and Availability -->
          <section class="w-1/3 p-4 bg-white rounded-lg shadow-md">
            <h3 class="font-semibold">Ratings:</h3>
            <StarRating :rating="averageRatings"></StarRating>

            <h3 class="mt-4 font-semibold">Subjects:</h3>
            <TutorProfileSubjects></TutorProfileSubjects>

            <h3 class="mt-4 font-semibold">Availability:</h3>
            <TutorProfileWorkDays />
            <TutorProfileWorkHours />

            <h3 class="mt-4 font-semibold">Rate:</h3>
            <TutorProfileRate></TutorProfileRate>

            <h3 class="mt-4 font-semibold">Personal details:</h3>
            <TutorProfileDetails></TutorProfileDetails>
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
                class="flex items-start bg-white p-6 rounded-lg shadow-md hover:shadow-lg border border-gray-200 transition-shadow"
              >
                <img
                  :src="school.image"
                  alt="School Logo"
                  class="w-16 h-16 mr-4 rounded-full object-cover"
                />
                <div>
                  <p class="text-lg font-semibold text-gray-900">
                    {{ school.name }}
                  </p>
                  <p class="text-sm text-gray-500 italic">
                    {{ school.course }}
                  </p>
                  <p class="text-sm text-gray-600 mt-2">
                    {{ formatDate(school.start_date) }} -
                    {{
                      school.end_date ? formatDate(school.end_date) : 'Present'
                    }}
                  </p>
                </div>
              </div>
            </div>

            <div class="p-4 bg-white rounded-lg shadow-md">
              <h3 class="font-semibold">Certification</h3>
              <div
                v-for="certificate in userData.certificates"
                :key="certificate.id"
                class="flex items-start bg-white p-6 rounded-lg shadow-md hover:shadow-lg border border-gray-200 transition-shadow"
              >
                <img
                  :src="certificate.image"
                  alt="Certificate Image"
                  class="w-16 h-16 mr-4 rounded-lg object-cover"
                />
                <div>
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
            </div>

            <div>
              <RatingsCarousel
                class="w-full"
                :ratingComments="ratingComments"
              ></RatingsCarousel>
            </div>
          </section>
        </div>
      </main>
    </SideBar>

    <HelpButton />
  </main>
</template>

<script setup>
import TutorProfileDetails from '@/components/TutorProfileDetails.vue'
import TutorProfileRate from '@/components/TutorProfileRate.vue'
import TutorProfileWorkDays from '@/components/TutorProfileWorkDays.vue'
import TutorProfileWorkHours from '@/components/TutorProfileWorkHours.vue'
import TutorProfileSubjects from '@/components/TutorProfileSubjects.vue'
import TutorProfileHeader from '@/components/TutorProfileHeader.vue'
import RatingsCarousel from '@/components/RatingsCarousel.vue'
import SideBar from '@/components/SideBar.vue'
import HelpButton from '@/components/HelpButton.vue'
import StarRating from '@/components/StarRating.vue'
import { computed, ref } from 'vue'
// import axiosInstance from '@/axiosInstance'

// TESTINGGG

// TESTINGGG

// const route = useRoute()

const getUserData = localStorage.getItem('user_data')
const parsedUserData = getUserData ? JSON.parse(getUserData) : {}
const userData = ref(parsedUserData)

const averageRatings = computed(() => {
  const ratings = userData.value.ratings.map(rating => rating.rate)
  const total = ratings.reduce((sum, rate) => sum + rate, 0)
  return total / ratings.length
})

const formatDate = date => {
  return new Intl.DateTimeFormat('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  }).format(new Date(date))
}

const ratingComments = computed(() => {
  const ratingsWithComments = userData.value.ratings.filter(
    rating => !!rating.comment,
  )
  return ratingsWithComments
})
</script>
