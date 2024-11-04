<template>
  <div class="w-full  ">
    <div
      class="relative flex flex-wrap items-center justify-center  overflow-hidden"
    >
      <div
        class="flex transition-transform duration-300 ease-in-out"
        :style="{ transform: `translateX(-${currentIndex * 100}%)` }"
      >
        <div
          v-for="(rating, index) in ratingComments"
          :key="rating.id"
          class="flex-shrink-0 w-full px-4"
          :class="{
            'scale-100': index === currentIndex,
            'scale-75':
              index === currentIndex - 1 || index === currentIndex + 1,
            'opacity-50': index !== currentIndex,
          }"
        >
          <div
            class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg border border-gray-200 transition-shadow"
          >
            <!-- Card Content -->
            <div class="flex h-auto">
              <div
                class="flex flex-col bg-white rounded-xl dark:bg-neutral-900"
              >
                <div class="flex-auto p-4 md:p-6">
                  <p
                    class="text-base italic md:text-lg text-gray-800 dark:text-neutral-200"
                  >
                    "{{ rating.comment }}"
                  </p>
                </div>

                <div
                  class="p-4 bg-gray-100 rounded-b-xl md:px-7 dark:bg-neutral-800"
                >
                  <div class="flex items-center gap-x-3">
                    <div class="shrink-0">
                      <img
                        class="size-8 sm:h-[2.875rem] sm:w-[2.875rem] rounded-full"
                        :src="rating.student.profile_image"
                        alt="Avatar"
                      />
                    </div>

                    <div class="grow">
                      <p
                        class="text-sm sm:text-base font-semibold text-gray-800 dark:text-neutral-200"
                      >
                        {{ rating.student.first_name }}
                        {{ rating.student.last_name }}
                      </p>
                      <StarRating :rating="rating.rate" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Navigation Buttons -->
      <button
        class="absolute left-0 p-2 bg-gray-200 rounded-full"
        @click="prev"
      >
        ◀
      </button>
      <button
        class="absolute right-0 p-2 bg-gray-200 rounded-full"
        @click="next"
      >
        ▶
      </button>
    </div>
  </div>
</template>

<script setup>
import StarRating from './StarRating.vue'
import { ref } from 'vue'

const props = defineProps({
  ratingComments: {
    type: Array,
    required: true,
  },
})

const currentIndex = ref(0)

const prev = () => {
  currentIndex.value =
    currentIndex.value === 0
      ? props.ratingComments.length - 1
      : currentIndex.value - 1
}

const next = () => {
  currentIndex.value = (currentIndex.value + 1) % props.ratingComments.length
}
</script>

<style scoped>
/* Smooth scaling animation */
.flex-shrink-0 {
  transition:
    transform 0.3s ease-in-out,
    opacity 0.3s ease-in-out;
}
</style>
