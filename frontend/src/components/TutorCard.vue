<template>
  <div>
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
  </div>
</template>

<script setup>
import StarRating from '@/components/StarRating.vue'
defineProps(['tutor'])
</script>
