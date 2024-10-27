<template>
  <div class="flex flex-col bg-white rounded-xl shadow-sm">
    <!-- Header Section with Blue Background -->
    <div class="bg-blue-600 p-4 rounded-t-xl flex justify-between items-center">
      <div class="flex items-center gap-3">
        <img
          alt="Tutor avatar"
          class="w-16 h-16 rounded-full"
        >
        <div class="text-white">
          <h2 class="font-medium text-lg">Jamal Murray, 18</h2>
          <p class="text-blue-100">Alcampo-Lawaan, Cebu</p>
        </div>
      </div>
      <button class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-400">
        BOOK
      </button>
    </div>

    <!-- Scrollable Content -->
    <div class="h-[calc(100vh-320px)] overflow-y-auto p-4 [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300">
      <!-- Bio Section -->
      <p class="text-gray-600 mb-6">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
        eiusmod tempor incididunt ut labore et dolore magna aliqua.
        Ut enim ad minim veniam, quis nostrud.
      </p>

      <!-- Subjects Section -->
      <div class="mb-6">
        <h3 class="font-medium mb-2">Subjects offered:</h3>
        <div class="flex gap-2">
          <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full">Math</span>
          <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full">Math</span>
        </div>
      </div>

      <!-- Availability Section -->
      <div class="mb-6">
        <h3 class="font-medium mb-2">Days available:</h3>
        <div class="flex gap-2">
          <span class="text-blue-600 font-medium">MONDAY</span>
          <span class="text-blue-600 font-medium">SUNDAY</span>
        </div>
      </div>

      <div class="mb-6">
        <h3 class="font-medium mb-2">Hours available:</h3>
        <p class="text-blue-600 font-medium">1-6pm</p>
      </div>

      <div class="mb-6">
        <h3 class="font-medium mb-2">Rate:</h3>
        <p>P500/Session</p>
      </div>

      <!-- Education Section -->
      <div>
        <h3 class="font-medium mb-2">Education:</h3>
        <div class="space-y-3">
          <div class="bg-gray-50 p-4 rounded-lg">
            <p class="font-medium">Buanoy National High School(2020)</p>
            <p class="text-gray-600">HUMSS</p>
          </div>
          <div class="bg-gray-50 p-4 rounded-lg">
            <p class="font-medium">Buanoy National High School(2020)</p>
            <p class="text-gray-600">HUMSS</p>
          </div>
        </div>
      </div>

      <!-- See more link -->
      <a href="#" class="mt-4 inline-flex items-center gap-x-1 text-sm font-semibold text-blue-600 hover:text-blue-700 hover:underline">
        See more
        <svg
          class="shrink-0 size-4"
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
      </a>
    </div>
  </div>
</template>

<script setup>
// You can add props or other logic here if needed
</script>
