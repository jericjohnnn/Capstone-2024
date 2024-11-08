<template>
  <div class="">
    <!-- Tutor Cards -->
    <div v-for="request in completedRequests" :key="request.id" class="mb-3">
      <div class=" bg-blue-200 flex items-center justify-between p-3  ">
        <div class="flex gap-x-3">
          <div class="shrink-0">
            <img
              class="shrink-0 size-16 rounded-full"
              :src="request.student.profile_image"
              alt="profile image"
            />
          </div>

          <div class="">
            <h1 class="text-lg font-medium text-gray-800">
              {{ request.student.first_name }} {{ request.student.last_name }} - requested for
            </h1>
            <button>report</button>
            <!-- badge -->
            <div
              class="inline-flex items-center py-1 px-3 rounded-full text-xs bg-blue-600 text-white"
            >
              {{ request.subject }}
            </div>
          </div>
        </div>

        <div>
          <button
            type="button"
            class="py-1 px-4 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg border border-blue-600 text-blue-600 hover:border-blue-500 hover:text-blue-500 focus:outline-none focus:border-blue-500 focus:text-blue-500 disabled:opacity-50 disabled:pointer-events-none"
          >
            Review Request
          </button>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import axiosInstance from '@/axiosInstance'

// const router = useRouter()
const route = useRoute()

const completedRequests = ref([])

const fetchStudentRequests = async () => {
  try {
    const response = await axiosInstance.get(
      `/api/student-requests?tab=completed`,
    )
    // current_page, last_page, links
    const { data } = response.data.student_requests

    completedRequests.value = data
    // currentPage.value = current_page
    // lastPage.value = last_page
    // paginationLinks.value = links
  } catch (err) {
    console.error('Error fetching tutors:', err)
  }
}

watch(
  () => route.query.tab,
  () => {
    if (route.query.tab === 'completed') {
      fetchStudentRequests()
    }
  },
)

onMounted(() => {
  fetchStudentRequests()
})
</script>
