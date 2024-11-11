<template>
  <div class="">
    <!-- Tutor Cards -->
    <div v-for="book in pendingRequests" :key="book.id" class="mb-3">
      <div class="bg-blue-200 flex items-center justify-between p-3">
        <div class="flex gap-x-3">
          <div class="shrink-0">
            <img
              class="shrink-0 size-16 rounded-full"
              :src="book.tutor.profile_image"
              alt="profile image"
            />
          </div>
          <div class="flex">
            <div class=" flex">
              <div class="flex flex-col">
                <h1 class="text-lg font-medium text-gray-800">
                  {{ book.tutor.first_name }} {{ book.tutor.last_name }}
                </h1>
                <button @click="selectTutor(book.tutor_id)" class="bg-blue-300">view profile</button>
              </div>
              <button class="underline">report</button>
            </div>
            <div>
              <p>You requested for</p>
              <div
                class="inline-flex items-center py-1 px-3 rounded-full text-xs bg-blue-600 text-white"
              >
                {{ book.subject }}
              </div>
            </div>
          </div>
        </div>

        <div>
          <button
            @click="goToBookDetails(book.id)"
            type="button"
            class="py-1 px-4 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg border border-blue-600 text-blue-600 hover:border-blue-500 hover:text-blue-500 focus:outline-none focus:border-blue-500 focus:text-blue-500 disabled:opacity-50 disabled:pointer-events-none"
          >
            Review Request
          </button>
          <p>{{ book.status }}</p>
        </div>
      </div>
    </div>
    <div>
      <PaginationLinks
        :links="paginationLinks"
        :current-page="currentPage"
        :last-page="lastPage"
      />
    </div>
  </div>
</template>

<script setup>
import PaginationLinks from '../PaginationLinks.vue'
import { ref, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axiosInstance from '@/axiosInstance'

const router = useRouter()
const route = useRoute()

const pendingRequests = ref([])
const currentPage = ref(1)
const lastPage = ref(1)
const paginationLinks = ref([])

const fetchSentRequests = async (page = 1) => {
  try {
    const response = await axiosInstance.get(
      `/api/sent-tutor-requests?tab=all&page=${page}`,
    )
    const { data, current_page, last_page, links } = response.data.sent_requests
    pendingRequests.value = data.sort(
      (a, b) => new Date(b.created_at) - new Date(a.created_at),
    )
    currentPage.value = current_page
    lastPage.value = last_page
    paginationLinks.value = links
  } catch (err) {
    console.error('Error fetching student requests:', err)
  }
}

const selectTutor = tutorId => {
  router.push({
    path: '/student/home',
    query: {
      page: currentPage.value,
      tutor_id: tutorId,
    },
  })
}

const goToBookDetails = bookId => {
  router.push({
    name: 'StudentBookDetails',
    params: { bookId: bookId },
  })
}

watch(
  () => [route.query.tab, route.query.page],
  ([newTab, newPage]) => {
    if (route.query.tab === newTab) {
      fetchSentRequests(newPage)
    }
  },
)

onMounted(() => {
  const initialPage = parseInt(route.query.page) || 1
  fetchSentRequests(initialPage)
})
</script>
