<template>
  <div>
    <div class="gap-4 flex">
      <!-- SEARCH BOX 1 -->
      <div class="grow">
        <div class="relative">
          <input
            type="text"
            id="hs-leading-icon"
            name="hs-leading-icon"
            class="py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
            placeholder="Search for a tutor"
          />
          <div
            class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4"
          >
            <svg
              class="shrink-0 size-4 text-gray-400 dark:text-white/60"
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
              <circle cx="11" cy="11" r="8"></circle>
              <path d="m21 21-4.3-4.3"></path>
            </svg>
          </div>
        </div>
      </div>
      <!-- End SearchBox -->

      <!-- SEARCH BOX 2 -->
      <div class="grow">
        <div class="relative">
          <input
            type="text"
            id="hs-leading-icon"
            name="hs-leading-icon"
            class="py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
            placeholder="Search for a subject"
          />
          <div
            class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4"
          >
            <svg
              class="shrink-0 size-4 text-gray-400 dark:text-white/60"
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
              <circle cx="11" cy="11" r="8"></circle>
              <path d="m21 21-4.3-4.3"></path>
            </svg>
          </div>
        </div>
      </div>
      <!-- End SearchBox -->
      <SearchButton>Search</SearchButton>
    </div>
  </div>
</template>

<script setup>
import SearchButton from './SearchButton.vue'
</script>
