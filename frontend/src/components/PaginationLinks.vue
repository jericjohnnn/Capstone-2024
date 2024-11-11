<template>
  <div>
    <nav v-if="links && links.length > 0" class="flex justify-between items-center gap-x-1" aria-label="Pagination">
      <!-- Previous Button -->
      <button
        v-if="links[0]"
        @click="handleClick(links[0])"
        :disabled="!links[0].url"
        type="button"
        class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-md text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10 transition-colors duration-200"
        aria-label="Previous"
      >
        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m15 18-6-6 6-6"></path>
        </svg>
        <span aria-hidden="true" class="hidden sm:block">Previous</span>
      </button>

      <!-- Page Indicators -->
      <div class="flex items-center gap-x-1">
        <span class="min-h-[38px] min-w-[38px] flex justify-center items-center border border-gray-200 text-gray-800 py-2 px-3 text-sm rounded-md focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-white dark:focus:bg-white/10">
          {{ currentPage }}
        </span>
        <span class="min-h-[38px] flex justify-center items-center text-gray-500 py-2 px-1.5 text-sm dark:text-neutral-500">of</span>
        <span class="min-h-[38px] flex justify-center items-center text-gray-500 py-2 px-1.5 text-sm dark:text-neutral-500">
          {{ lastPage }}
        </span>
      </div>

      <!-- Next Button -->
      <button
        v-if="links[links.length - 1]"
        @click="handleClick(links[links.length - 1])"
        :disabled="!links[links.length - 1].url"
        type="button"
        class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-md text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10 transition-colors duration-200"
      >
        <span aria-hidden="true" class="hidden sm:block">Next</span>
        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m9 18 6-6-6-6"></path>
        </svg>
      </button>
    </nav>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()

const props = defineProps({
  links: {
    type: Array,
    default: () => [],
    required: true
  },
  currentPage: {
    type: Number,
    default: 1,
    required: true
  },
  lastPage: {
    type: Number,
    default: 1,
    required: true
  },
  basePathName: {
    type: String,
  },
});

const handleClick = (link) => {
  if (link.url) {
    const page = new URL(link.url).searchParams.get('page');
    const currentTab = ref(route.query.tab)
    router.push({
      name: props.basePathName,
      query: {
        tab: currentTab.value,
        page: parseInt(page),
      },
    });
  }
};
</script>
