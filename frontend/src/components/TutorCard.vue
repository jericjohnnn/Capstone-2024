<template>
  <div class="mb-3">
    <div class="flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-lg transition dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
      <!-- Tutor Info Section -->
      <div class="p-4 md:p-5 flex items-center justify-between">
        <div class="flex items-center gap-x-3">
          <div class="shrink-0">
            <img
              class="size-14 rounded-full object-cover border-2 border-gray-100"
              :src="tutors.profile_image || defaultProfileImage"
              :alt="tutors.tutor_name"
            />
          </div>

          <div class="flex flex-col gap-1">
            <h1 class="text-lg font-bold text-gray-800 dark:text-white line-clamp-1">
              {{ tutors.tutor_name }}
            </h1>
            <div class="flex items-center gap-2">
              <span
                class="inline-flex items-center py-0.5 px-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
              >
                {{ tutors.tutor_subjects[tutors.tutor_subjects.length-1].abbreviation }}
              </span>
            </div>
          </div>
        </div>

        <!-- Rating and Button -->
        <div class="shrink-0 flex flex-col items-end gap-2">
          <StarRating :rating="tutors.tutor_rating" class="text-sm"></StarRating>
          <button
            type="button"
            class="py-1.5 px-4 text-xs font-medium rounded-md border border-blue-600 text-blue-600 hover:bg-blue-50 transition-colors duration-200"
          >
            View Profile
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import StarRating from '@/components/StarRating.vue'

const defaultProfileImage =
  'data:image/svg+xml;base64,' +
  btoa(`
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
    <circle cx="12" cy="12" r="11" fill="white" stroke="#E5E7EB" stroke-width="2"/>
    <circle cx="12" cy="8" r="3.5" fill="#9CA3AF"/>
    <path d="M12 12.5c-3 0-5.5 1.5-7 3.5 1.5 3 4 5 7 5s5.5-2 7-5c-1.5-2-4-3.5-7-3.5z" fill="#9CA3AF"/>
  </svg>`)

defineProps({
  tutors: {
    type: Object,
    required: true,
  },
})
</script>
