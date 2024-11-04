<template>
  <main class="bg-blue-50">
      <SideBar>
      <main class="container flex flex-col gap-14 min-h-screen p-5 outline">
        <!-- Search Components -->
        <div class="pt-6">
          <TutorSearch></TutorSearch>
          <div class="">
            <AllSubjects></AllSubjects>
          </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex gap-7">
          <!-- Left Column - Tutor Cards -->
          <div
            class="max-w-md flex h-[calc(100vh-240px)] flex-col justify-between"
          >
            <div class="flex-grow overflow-auto">
              <TutorCard
                v-for="tutor in tutors"
                :key="tutor.id"
                :tutors="tutor"
                :loading="loading"
                @click="selectTutor(tutor.id)"
              />
            </div>

            <!-- Pagination inside left column -->
            <div class="w-11/12 mt-4">
              <PaginationLinks
                :links="paginationLinks"
                :current-page="currentPage"
                :last-page="lastPage"
                @page-click="goToPage"
              />
            </div>
          </div>
          <!-- Right Column - Tutor Details -->
          <div class="max-w-lg outline">
            <div v-if="tutorDetails">
              <TutorDetailsCard :tutor="tutorDetails"></TutorDetailsCard>
            </div>
            <div v-else>
              <p class="text-center text-gray-500">Select a Tutor</p>
            </div>
          </div>
        </div>
      </main>
  </SideBar>
    <!-- Help Button -->
    <HelpButton></HelpButton>
  </main>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import SideBar from '@/components/SideBar.vue'
import TutorSearch from '@/components/TutorSearch.vue'
import AllSubjects from '@/components/AllSubjects.vue'
import TutorDetailsCard from '@/components/TutorDetailsCard.vue'
import TutorCard from '@/components/TutorCard.vue'
import PaginationLinks from '@/components/PaginationLinks.vue'
import HelpButton from '@/components/HelpButton.vue'
import axiosInstance from '@/axiosInstance'

const router = useRouter()
const route = useRoute()

const tutors = ref([])
const tutorDetails = ref(null)
const loading = ref(false)
const currentPage = ref(1)
const lastPage = ref(1)
const paginationLinks = ref([])

const fetchTutors = async (page = 1) => {
  try {
    loading.value = true
    const response = await axiosInstance.get(`/api/tutors?page=${page}`)
    // Handle Laravel pagination response
    const { data, current_page, last_page, links } =
      response.data.tutor_previews

    tutors.value = data
    currentPage.value = current_page
    lastPage.value = last_page
    paginationLinks.value = links
  } catch (err) {
    console.error('Error fetching tutors:', err)
  } finally {
    loading.value = false
  }
}

const fetchTutorDetails = async tutorId => {
  try {
    const response = await axiosInstance.get(`/api/tutor-detail/${tutorId}`)
    tutorDetails.value = response.data.tutor
  } catch (err) {
    console.error('Error fetching tutor details:', err)
  }
}

const goToPage = pageNumber => {
  router.push({
    path: '/student/home',
    query: {
      page: pageNumber,
    },
  })
}

const selectTutor = tutorId => {
  router.push({
    path: '/student/home',
    query: {
      page: currentPage.value,
      tutor_id: tutorId, // Add tutor_id to the query params
    },
  })
}

// Watch for changes in route query
watch(
  () => [route.query.page, route.query.tutor_id], // Watch for both page and tutor_id changes
  ([newPage, newTutorId]) => {
    const page = parseInt(newPage) || 1
    fetchTutors(page)

    if (newTutorId) {
      fetchTutorDetails(newTutorId) // Fetch tutor details if tutor_id is present
    }
  },
)

onMounted(() => {
  const initialPage = parseInt(route.query.page) || 1
  fetchTutors(initialPage)

  const initialTutorId = route.query.tutor_id
  if (initialTutorId) {
    fetchTutorDetails(initialTutorId)
  }
})
</script>
