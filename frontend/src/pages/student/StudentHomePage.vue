<template>
  <div class="min-h-screen  bg-blue-50">
    <SideBar>
      <main class="flex-1 p-6">

        <div class="mb-6">
          <!-- Search Header -->
           <TutorSearch></TutorSearch>
          <!-- Subject Pills -->
        </div>

        <!-- Tutor Cards -->


        <!-- Pagination -->

      </main>
    </SideBar>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import SideBar from '@/components/SideBar.vue'
import TutorSearch from '@/components/TutorSearch.vue';
import axiosInstance from '@/axiosInstance'

const currentPage = ref(1)
const tutors = ref([])
const loading = ref(false)
const error = ref(null)

const fetchTutors = async (page = 1) => {
  try {
    loading.value = true
    const response = await axiosInstance.get(`/api/tutors?page=${page}`)
    tutors.value = response.data.tutor_previews
    currentPage.value = response.data.pagination.current_page
  } catch (err) {
    error.value = 'Failed to load tutors'
    console.error('Error fetching tutors:', err)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchTutors()
})
</script>
