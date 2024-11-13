<template>
  <main class="bg-blue-50 h-screen">
    <SideBar>
      <main class="container h-full py-5">
        <!-- Search Components -->
        <div class="mb-6">
          <BreadCrumb
            :breadcrumbs="[{ label: 'Home', route: '/student/home' }]"
          />
          <TutorSearch class="pt-3"></TutorSearch>
          <div>
            <AllSubjects></AllSubjects>
          </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex flex-col md:flex-row md:gap-8">
          <!-- Left Column - Tutor Cards -->
          <div class="w-full md:w-[380px] h-[calc(100vh-220px)]">
            <!-- Scrollable Tutor Cards Container -->
            <div class="h-[calc(100%-60px)] overflow-y-auto pr-3">
              <div
                v-if="tutorsLoading"
                class="flex justify-center items-center h-full"
              >
                <LoaderSpinner />
              </div>
              <div v-else>
                <TutorCard
                  v-for="tutor in tutors"
                  :key="tutor.id"
                  :tutor="tutor"
                  :loading="tutorsLoading"
                  @click="selectTutor(tutor.id)"
                />
                <div ref="loadMore" class="h-10 md:hidden"></div>
              </div>
            </div>

            <!-- Pagination -->
            <div class="h-[60px] hidden md:block pt-4">
              <PaginationLinks
                :links="paginationLinks"
                :current-page="currentPage"
                :last-page="lastPage"
              />
            </div>
          </div>

          <!-- Right Column - Tutor Details -->
          <div
            class="w-full md:w-[calc(100%-380px-2rem)] h-[calc(100vh-220px)] hidden md:block"
          >
            <div
              v-if="tutorDetailsLoading"
              class="flex justify-center items-center h-full"
            >
              <LoaderSpinner />
            </div>
            <div v-else-if="tutorDetails" class="h-full">
              <TutorDetailsCard :tutor="tutorDetails"></TutorDetailsCard>
            </div>
            <div
              v-else
              class="h-full flex items-center justify-center rounded-sm shadow-sm"
            >
              <p class="text-center text-gray-500">Select a Tutor</p>
            </div>
          </div>
        </div>
      </main>
    </SideBar>
    <HelpButton></HelpButton>
  </main>
</template>

<script setup>
import BreadCrumb from '@/components/BreadCrumb.vue'
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
import LoaderSpinner from '@/components/reusables/LoaderSpinner.vue'

const router = useRouter()
const route = useRoute()

const tutors = ref([])
const tutorDetails = ref(null)
const tutorsLoading = ref(false)
const tutorDetailsLoading = ref(false)
const currentPage = ref(1)
const lastPage = ref(1)
const paginationLinks = ref([])

const fetchTutors = async (page = 1) => {
  try {
    tutorsLoading.value = true
    const response = await axiosInstance.get(`/api/tutors?page=${page}`)
    const { data, current_page, last_page, links } =
      response.data.tutor_previews

    tutors.value = data
    currentPage.value = current_page
    lastPage.value = last_page
    paginationLinks.value = links
  } catch (err) {
    console.error('Error fetching tutors:', err)
  } finally {
    tutorsLoading.value = false
  }
}

const fetchTutorDetails = async tutorId => {
  try {
    tutorDetailsLoading.value = true
    const response = await axiosInstance.get(`/api/tutor-detail/${tutorId}`)
    tutorDetails.value = response.data.tutor
  } catch (err) {
    console.error('Error fetching tutor details:', err)
  } finally {
    tutorDetailsLoading.value = false
  }
}

const selectTutor = tutorId => {
  router.push({
    path: '/student/home',
    query: {
      ...route.query, // Preserve existing query parameters
      tutor_id: tutorId,
    },
  })
}

watch(
  () => route.query.page,
  (newPage, oldPage) => {
    if (newPage !== oldPage) {
      const page = parseInt(newPage) || 1
      fetchTutors(page)
    }
  },
)

watch(
  () => route.query.tutor_id,
  (newTutorId, oldTutorId) => {
    if (newTutorId !== oldTutorId && newTutorId) {
      fetchTutorDetails(newTutorId)
    }
  },
)

onMounted(() => {
  // Initial fetch of tutors
  const initialPage = parseInt(route.query.page) || 1
  fetchTutors(initialPage)

  // Only fetch initial tutor details if tutor_id exists in URL
  const initialTutorId = route.query.tutor_id
  if (initialTutorId) {
    fetchTutorDetails(initialTutorId)
  }
})
</script>
