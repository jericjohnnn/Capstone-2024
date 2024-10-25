<template>
  <div class="min-h-screen flex bg-blue-50">
    <!-- Sidebar -->
    <aside class="w-64 bg-white p-6 flex flex-col">
      <div class="mb-8">
        <h1 class="text-xl font-bold">T.U.D.L.O.</h1>
      </div>

      <nav class="flex-grow">
        <ul class="space-y-4">
          <li v-for="item in menuItems" :key="item.path">
            <router-link
              :to="item.path"
              class="flex items-center space-x-3 text-gray-600 hover:text-blue-600"
            >
              <component :is="item.icon" class="w-5 h-5" />
              <span>{{ item.name }}</span>
            </router-link>
          </li>
        </ul>
      </nav>

      <div class="mt-auto flex items-center space-x-3">
        <img
          :src="currentUser.image"
          alt="Profile"
          class="w-10 h-10 rounded-full"
        />
        <span class="font-medium">{{ currentUser.name }}</span>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <!-- Search Header -->
      <div class="mb-6">
        <div class="flex space-x-4 mb-4">
          <input
            type="text"
            placeholder="Find tutors"
            class="px-4 py-2 rounded-full border"
          />
          <input
            type="text"
            placeholder="Find subjects"
            class="px-4 py-2 rounded-full border"
          />
          <button class="bg-blue-600 text-white px-6 py-2 rounded-full">
            Search
          </button>
        </div>

        <!-- Subject Pills -->
        <div class="flex space-x-2 overflow-x-auto">
          <button
            v-for="subject in subjects"
            :key="subject"
            class="px-4 py-1 rounded-full border bg-white hover:bg-gray-50"
          >
            {{ subject }}
          </button>
          <button class="p-1">
            <ChevronRightIcon class="w-6 h-6" />
          </button>
        </div>
      </div>

      <!-- Tutor Cards -->
      <div class="space-y-4">
        <div
          v-for="tutor in tutors"
          :key="tutor.id"
          class="bg-white p-4 rounded-lg shadow-sm flex items-center"
        >
          <img
            :src="tutor.profile_image"
            :alt="tutor.tutor_name"
            class="w-12 h-12 rounded-full"
          />
          <div class="ml-4 flex-grow">
            <div class="flex items-center justify-between">
              <div>
                <h3 class="font-medium">{{ tutor.tutor_name }}</h3>
                <div class="flex space-x-2">
                  <span
                    v-for="subject in tutor.tutor_subjects.slice(0, 2)"
                    :key="subject"
                    class="text-sm text-white bg-blue-600 px-2 py-0.5 rounded-full"
                  >
                    {{ subject }}
                  </span>
                </div>
              </div>
              <div class="text-right">
                <StarRating :rating="tutor.tutor_rating" />
                <button class="text-blue-600 text-sm">See profile</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div class="flex justify-center mt-6 space-x-2">
        <button class="p-1">
          <ChevronLeftIcon class="w-5 h-5" />
        </button>
        <button
          v-for="page in 6"
          :key="page"
          class="px-3 py-1 rounded-full hover:bg-gray-100"
          :class="{ 'bg-blue-600 text-white': currentPage === page }"
        >
          {{ page }}
        </button>
        <span>...</span>
        <button class="p-1">
          <ChevronRightIcon class="w-5 h-5" />
        </button>
      </div>

      <!-- Help Button -->
      <button class="fixed bottom-6 right-6 bg-blue-600 text-white px-4 py-2 rounded-full">
        Need help?
      </button>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
// import { HomeIcon, CalendarIcon, ClipboardIcon, BellIcon, ChevronLeftIcon, ChevronRightIcon } from 'lucide-react'
import StarRating from '@/components/StarRating.vue'
import axiosInstance from '@/axiosInstance'

const menuItems = [
  { name: 'Home', path: '/home'},
  { name: 'Schedule', path: '/schedule'},
  { name: 'Tutor requests', path: '/requests' },
  { name: 'Notifications', path: '/notifications'},
]

const subjects = ['English', 'P.E', 'Science', 'Math', 'History', 'Geography']
const currentPage = ref(1)
const tutors = ref([])
const loading = ref(false)
const error = ref(null)

const currentUser = ref({
  name: 'JAMAL MURRAY',
  image: 'https://picsum.photos/200/200'
})

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
