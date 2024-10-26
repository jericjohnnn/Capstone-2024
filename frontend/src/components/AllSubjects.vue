<template>
  <div>
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
</template>

<script setup>

const subjects = ['English', 'P.E', 'Science', 'Math', 'History', 'Geography']
</script>
