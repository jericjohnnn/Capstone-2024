<template>
  <main class="w-full min-h-screen bg-white">
    <SideBar>
      <!-- Container with gap between grid items -->
      <div class="grid grid-cols-1 gap-4 min-h-screen  py-5">
        
        <!-- Breadcrumb Section -->
        <div class="w-full h-fit ">
          <BreadCrumb
            :breadcrumbs="[{ label: 'Home', route: '/student/home' }]"
          />
        </div>

        <!-- Search Section -->
        <div class="w-full h-fit ">
          <TutorSearch></TutorSearch>
          <div>
            <AllSubjects></AllSubjects>
          </div>
        </div>

        <!-- Main Content Area -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4  min-h-20 ">
          
          <!-- Left Column - Split into two rows -->
          <div class="grid grid-rows-[1fr,auto] gap-4">
            
            <!-- Tutor Cards Section -->
            <div class="w-full min-h-96 "> <!-- Ensuring minimum height during loading -->
              <div
                v-if="tutorsLoading"
                class="flex justify-center items-center h-full "
              >
                <LoaderSpinner />
              </div>
              <div v-else>
                <TutorCard
                  v-for="tutor in tutors"
                  :key="tutor.id"
                  :tutor="tutor"
                  :loading="tutorsLoading"
                  @triggerSelectTutor="selectTutor(tutor.id)"
                />
              </div>
            </div>

            <!-- Pagination Section -->
            <div class="w-full ">
              <PaginationLinks
                :links="paginationLinks"
                :current-page="currentPage"
                :last-page="lastPage"
              />
            </div>
          </div>

          <!-- Tutor Details Section -->
          <div class="w-full hidden md:block min-h-[400px] "> <!-- Consistent height for layout stability -->
            <div
              v-if="tutorDetailsLoading"
              class="flex justify-center items-center h-full "
            >
              <LoaderSpinner />
            </div>
            <div v-else-if="tutorDetails" class="h-full ">
              <TutorDetailsCard :tutor="tutorDetails"></TutorDetailsCard>
            </div>
            <div
              v-else
              class="h-full flex items-center justify-center rounded-sm shadow-sm "
            >
              <p class="text-center text-gray-500">Select a Tutor</p>
            </div>
          </div>
        </div>
      </div>
    </SideBar>
    
    <FooterSection class="md:hidden" />
    <HelpButton></HelpButton>
  </main>
</template>


<script setup>
import FooterSection from '@/sections/FooterSection.vue'
import BreadCrumb from '@/components/BreadCrumb.vue'
import { ref, onMounted, watch, onUnmounted } from 'vue'
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
// Mobile View
const isMobileView = ref(window.innerWidth < 640)
const resizeHandler = () => {
  isMobileView.value = window.innerWidth < 640
}

const fetchTutors = async (page = 1) => {
  try {
    tutorsLoading.value = true
    const endpoint = isMobileView.value ? `/api/tutors-mobile` : `/api/tutors`
    const response = await axiosInstance.get(`${endpoint}?page=${page}`)
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

watch(isMobileView, (newIsMobile, oldIsMobile) => {
  if (newIsMobile !== oldIsMobile) {
    // Re-fetch tutors with current page when view changes
    const currentPageNumber = parseInt(route.query.page) || 1
    fetchTutors(currentPageNumber)
  }
})

onMounted(() => {
  // Add resize event listener
  window.addEventListener('resize', resizeHandler)

  // Initial fetch of tutors
  const initialPage = parseInt(route.query.page) || 1
  fetchTutors(initialPage)

  // Only fetch initial tutor details if tutor_id exists in URL
  const initialTutorId = route.query.tutor_id
  if (initialTutorId) {
    fetchTutorDetails(initialTutorId)
  }
})

onUnmounted(() => {
  window.removeEventListener('resize', resizeHandler)
})
</script>
