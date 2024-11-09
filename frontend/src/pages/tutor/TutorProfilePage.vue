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
            <StarRating :rating="averageRatings ? averageRatings : 0"></StarRating>

            <TutorProfileSubjects></TutorProfileSubjects>

            <h3 class="mt-4 font-semibold">Availability:</h3>
            <TutorProfileWorkDays />
            <TutorProfileWorkHours />

            <TutorProfileRate></TutorProfileRate>

            <TutorProfileDetails></TutorProfileDetails>
          </section>

          <!-- Bio, Education, and Certification -->
          <section class="flex-1 space-y-4">
            <div class="p-4 bg-white rounded-lg shadow-md">
              <TutorProfileBiography></TutorProfileBiography>
            </div>

            <div class="p-4 bg-white rounded-lg shadow-md">
              <h3 class="font-semibold">Education</h3>
              <!-- <EducationTest></EducationTest> -->
              <TutorProfileEducation></TutorProfileEducation>
            </div>

            <div class="p-4 bg-white rounded-lg shadow-md">
              <h3 class="font-semibold">Certification</h3>
              <TutorProfileCertificate></TutorProfileCertificate>
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
// import EducationTest from '@/components/EducationTest.vue'

import TutorProfileCertificate from '@/components/TutorProfile/TutorProfileCertificate.vue'
import TutorProfileEducation from '@/components/TutorProfile/TutorProfileEducation.vue'
import TutorProfileBiography from '@/components/TutorProfile/TutorProfileBiography.vue'
import TutorProfileDetails from '@/components/TutorProfile/TutorProfileDetails.vue'
import TutorProfileRate from '@/components/TutorProfile/TutorProfileRate.vue'
import TutorProfileWorkDays from '@/components/TutorProfile/TutorProfileWorkDays.vue'
import TutorProfileWorkHours from '@/components/TutorProfile/TutorProfileWorkHours.vue'
import TutorProfileSubjects from '@/components/TutorProfile/TutorProfileSubjects.vue'
import TutorProfileHeader from '@/components/TutorProfile/TutorProfileHeader.vue'
import RatingsCarousel from '@/components/RatingsCarousel.vue'
import SideBar from '@/components/SideBar.vue'
import HelpButton from '@/components/HelpButton.vue'
import StarRating from '@/components/StarRating.vue'
import { computed, ref, onMounted } from 'vue'
import axiosInstance from '@/axiosInstance'

// TESTINGGG

// TESTINGGG

// const route = useRoute()

const parsedUserData = JSON.parse(localStorage.getItem('user_data') || '{}')
const userData = ref(parsedUserData)

const averageRatings = computed(() => {
  const ratings = userData.value.ratings.map(rating => rating.rate)
  const total = ratings.reduce((sum, rate) => sum + rate, 0)
  return total / ratings.length
})

const ratingComments = computed(() => {
  const ratingsWithComments = userData.value.ratings.filter(
    rating => !!rating.comment,
  )
  return ratingsWithComments
})

const fetchTutorProfileInfo = async () => {
  try {
    const response = await axiosInstance.get(`/api/tutor-info`)
    userData.value = response.data.tutor
    localStorage.setItem('user_data', JSON.stringify(userData.value));
  } catch (err) {
    console.error('Error fetching tutor details:', err)
  }
}



onMounted(fetchTutorProfileInfo)
</script>
