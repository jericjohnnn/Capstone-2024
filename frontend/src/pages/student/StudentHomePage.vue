<template>
  <main class="bg-blue-50">
    <SideBar>
      <main class="container flex flex-col gap-6 min-h-screen">
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
          <div class="w-2/4 flex h-[calc(100vh-220px)] flex-col justify-between">
            <div class="flex-grow overflow-auto">
              <TutorCard :tutors="tutors" :loading="loading" />
            </div>

            <!-- Pagination inside left column -->
            <div class="w-11/12 mt-4">
              <PaginationLinks
                :currentPage="currentPage"
                :totalPages="totalPages"
                @change-page="handlePageChange"
              />
            </div>
          </div>

          <!-- Right Column - Tutor Details -->
          <div class="w-3/5">
            <TutorDetailsCard></TutorDetailsCard>
          </div>
        </div>
      </main>
    </SideBar>

    <!-- Help Button -->
    <HelpButton></HelpButton>
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import SideBar from '@/components/SideBar.vue'
import TutorSearch from '@/components/TutorSearch.vue'
import AllSubjects from '@/components/AllSubjects.vue'
import TutorDetailsCard from '@/components/TutorDetailsCard.vue'
import TutorCard from '@/components/TutorCard.vue'
import PaginationLinks from '@/components/PaginationLinks.vue'
import HelpButton from '@/components/HelpButton.vue'
import axiosInstance from '@/axiosInstance'

const tutors = ref([])
const loading = ref(false)
const currentPage = ref(1)
const totalPages = ref(1)

const fetchTutors = async page => {
  try {
    loading.value = true
    const response = await axiosInstance.get(`/api/tutors?page=${page}`)
    tutors.value = response.data.tutor_previews
    currentPage.value = response.data.current_page
    totalPages.value = response.data.last_page
  } catch (err) {
    console.error('Error fetching tutors:', err)
  } finally {
    loading.value = false
  }
}

const handlePageChange = page => {
  if (page !== currentPage.value) {
    fetchTutors(page)
  }
}

onMounted(() => {
  fetchTutors(currentPage.value)
})
</script>
