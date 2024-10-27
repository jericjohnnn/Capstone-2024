<template>
  <div class="relative flex items-center">
    <!-- Left Arrow -->
    <button
      @click="scrollLeft"
      class="absolute left-0 z-10 bg-white shadow-md rounded-full p-2 hover:bg-gray-50"
    >
      <svg
        class="w-6 h-6 text-gray-600"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
      >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </button>

    <!-- Scrollable Container -->
    <div
      ref="scrollContainer"
      class="flex gap-3 overflow-x-auto px-10 py-2 scroll-smooth no-scrollbar"
    >
      <button
        v-for="subject in subjects"
        :key="subject"
        class="px-6 py-2 rounded-full bg-white border shadow-sm hover:bg-gray-50 whitespace-nowrap"
        :class="{ 'bg-blue-100 border-blue-200': selectedSubject === subject }"
        @click="selectSubject(subject)"
      >
        {{ subject }}
      </button>
    </div>

    <!-- Right Arrow -->
    <button
      @click="scrollRight"
      class="absolute right-0 z-10 bg-white shadow-md rounded-full p-2 hover:bg-gray-50"
    >
      <svg
        class="w-6 h-6 text-gray-600"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
      >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
    </button>
  </div>
</template>

<script setup>
import { ref } from 'vue'

// Sample subjects - you can pass these as props instead
const subjects = [
  'English',
  'P.E',
  'Science',
  'Math',
  'History',
  'Geography',
  'Physics',
  'Chemistry',
  'Biology',
  'Literature'
]

const selectedSubject = ref(null)
const scrollContainer = ref(null)

const selectSubject = (subject) => {
  selectedSubject.value = subject
  // Emit the selected subject if needed
  // emit('update:modelValue', subject)
}

const scrollLeft = () => {
  if (scrollContainer.value) {
    scrollContainer.value.scrollBy({
      left: -200,
      behavior: 'smooth'
    })
  }
}

const scrollRight = () => {
  if (scrollContainer.value) {
    scrollContainer.value.scrollBy({
      left: 200,
      behavior: 'smooth'
    })
  }
}
</script>

<style scoped>
/* Hide scrollbar but keep functionality */
.no-scrollbar::-webkit-scrollbar {
  display: none;
}
.no-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
