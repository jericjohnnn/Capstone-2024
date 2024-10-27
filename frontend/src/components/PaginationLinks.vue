<template>
  <div>
    <nav class="flex justify-between items-center gap-x-1" aria-label="Pagination">
      <button
        type="button"
        :disabled="currentPage === 1"
        @click="$emit('change-page', currentPage - 1)"
        class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10"
        aria-label="Previous"
      >
        <svg
          class="shrink-0 size-3.5"
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <path d="m15 18-6-6 6-6"></path>
        </svg>
        <span aria-hidden="true" class="hidden sm:block">Previous</span>
      </button>

      <div class="flex items-center gap-x-1">
        <button
          v-for="page in totalPages"
          :key="page"
          @click="$emit('change-page', page)"
          :class="[
            'min-h-[38px] min-w-[38px] flex justify-center items-center py-2 px-3 text-sm rounded-lg focus:outline-none',
            currentPage === page
              ? 'bg-gray-200 text-gray-800 dark:bg-neutral-600 dark:text-white'
              : 'text-gray-800 hover:bg-gray-100 dark:text-white dark:hover:bg-white/10'
          ]"
          :aria-current="currentPage === page ? 'page' : null"
        >
          {{ page }}
        </button>
      </div>

      <button
        type="button"
        :disabled="currentPage === totalPages"
        @click="$emit('change-page', currentPage + 1)"
        class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10"
      >
        <span aria-hidden="true" class="hidden sm:block">Next</span>
        <svg
          class="shrink-0 size-3.5"
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <path d="m9 18 6-6-6-6"></path>
        </svg>
      </button>
    </nav>
  </div>
</template>

<script setup>
defineProps({
  currentPage: Number,
  totalPages: Number
})

defineEmits(['change-page'])
</script>
