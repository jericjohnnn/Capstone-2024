<template>
  <div class="border p-4 rounded flex items-center space-x-4">
    <img
      :src="tutor.profile_image"
      alt="Tutor profile"
      class="w-16 h-16 rounded-full object-cover"
    />
    <div>
      <h3 class="text-lg font-bold">{{ tutor.tutor_name }}, {{ tutor.age }}</h3>
      <div class="flex space-x-2">
        <span
          v-for="subject in tutor.tutor_subjects"
          :key="subject"
          class="bg-blue-100 text-blue-800 px-2 py-1 rounded"
        >
          {{ subject }}
        </span>
      </div>
      <StarRating :rating="tutor.tutor_rating" />
    </div>
  </div>
</template>

<script setup>
import StarRating from '@/components/StarRating.vue';
defineProps(['tutor']);
</script>
