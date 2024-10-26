<template>
  <main class="bg-blue-50">
    <SideBar>
      <main class="min-h-screen flex justify-center items-center outline outline-red-400">

        <div class="Search-Component outline">
          <!-- Search Header -->
           <TutorSearch></TutorSearch>
          <!-- Subject Pills -->
          <AllSubjects></AllSubjects>

        </div>

        <!-- Tutor Cards -->


        <!-- Pagination -->

      </main>
    </SideBar>
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import SideBar from '@/components/SideBar.vue'
import TutorSearch from '@/components/TutorSearch.vue';
import AllSubjects from '@/components/AllSubjects.vue';
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
