<template>
<div class="flex items-center gap-6 mb-4">
  <img
    :src="tutor.profile_image"
    alt="Tutor"
    class="w-20 h-20 rounded-full object-cover"
  />
  <div class="flex-1">
    <StarRating :rating="averageRatings" class="mb-1" />
    <h2 class="text-xl font-semibold mb-2">
      {{ tutor.first_name }} {{ tutor.last_name }}
    </h2>
    <div class="flex flex-wrap gap-2">
      <span
        v-for="subject in tutor.subjects"
        :key="subject.id"
        class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm"
      >
        {{ subject.name }}
      </span>
    </div>
  </div>
  <div class="text-right">
    <p class="text-lg font-semibold text-blue-600">
      ₱{{ tutor.tutor_rate }}/Hour
    </p>
  </div>
</div>
</template>
<script setup>
import StarRating from '@/components/StarRating.vue';
import { computed } from 'vue'

const props = defineProps({
  tutor: {
    type: Object,
    required: true
  }
})


const averageRatings = computed(() => {
  if (!props.tutor?.ratings || props.tutor.ratings.length === 0) {
    return 0
  }
  const ratings = props.tutor.ratings.map(rating => rating.rate)
  const total = ratings.reduce((sum, rate) => sum + rate, 0)
  return total / ratings.length
})
</script>