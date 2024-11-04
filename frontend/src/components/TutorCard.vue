<template>
  <div class="mb-5">
    <!-- Tutor Cards -->
    <div class="flex items-center justify-between p-3 w-11/12 bg-white">
      <div class="flex gap-x-3">
        <div class=" shrink-0">
          <img
            class="shrink-0 size-16 rounded-full"
            :src="tutors.profile_image"
            :alt="tutors.tutor_name"
          />
        </div>

        <div class="">
          <h1 class="text-lg font-medium text-gray-800 dark:text-neutral-200">
            {{ tutors.tutor_name }}
          </h1>
          <!-- badges -->
          <div class="flex-wrap gap-2">
            <span
              v-for="subject in tutors.tutor_subjects"
              :key="subject"
              class="inline-flex items-center py-1 px-3 rounded-full text-xs  bg-blue-600 text-white dark:bg-blue-500"
            >
              {{ subject }}
            </span>
          </div>
        </div>
      </div>

      <div class="">
        <StarRating :rating="tutors.tutor_rating"></StarRating>
        <div>
          <button
            type="button"
            class="py-1 px-4 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg border border-blue-600 text-blue-600 hover:border-blue-500 hover:text-blue-500 focus:outline-none focus:border-blue-500 focus:text-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:border-blue-500 dark:text-blue-500 dark:hover:text-blue-400 dark:hover:border-blue-400"
          >
            See Profile
          </button>
        </div>
      </div>
    </div>
    <!-- Tutor Cards -->
  </div>
</template>

<script setup>
import StarRating from '@/components/StarRating.vue'

defineProps({
  tutors: {
    type: Object,
    required: true,
  },
})
</script>
