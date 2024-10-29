<template>
  <div class="flex flex-row">
    <SideBar />
    <div class="flex flex-col flex-grow">
      <!-- Header Section -->
      <div class="flex items-center py-8">

        <div class="flex items-center ml-[150px]">
          <input
            type="text"
            placeholder="Search tutors..."
            class="px-4 py-2 border border-gray-300 rounded-lg w-[350px] focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <img src="data:image/svg+xml;base64,..." alt="Bell Icon" class="ml-5 w-6 h-6" />
          <div class="ml-5 w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
            <span class="text-white font-bold">P</span>
          </div>
        </div>
      </div>
    <!-- Breadcrumb Tabs -->
    <div class="flex space-x-4 mb-4 ml-6 text-md font-bold">
      <button @click="currentTab = 'all'" :class="currentTab === 'all' ? 'font-bold underline' : ''">All</button>
      <button @click="currentTab = 'Pending'" :class="currentTab === 'Pending' ? 'font-bold underline' : ''">Pending</button>
      <button @click="currentTab = 'Accepted'" :class="currentTab === 'Accepted' ? 'font-bold underline' : ''">Accepted</button>
      <button @click="currentTab = 'Rejected'" :class="currentTab === 'Rejected' ? 'font-bold underline' : ''">Rejected</button>
    </div>

    <!-- Conditional Rendering of Tab Components -->
    <component :is="currentComponent" :current-tab="currentTab" />
  </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import AllTutors from './AllTutors.vue';
import SideBar from './SideBar.vue';
import PendingTutors from './PendingTutors.vue';
import AcceptedTutors from './AcceptedTutors.vue';
import RejectedTutors from './RejectedTutors.vue';

const currentTab = ref('all');

// Dynamically set the component to load based on the selected tab
const currentComponent = computed(() => {
  switch (currentTab.value) {
    case 'Pending':
      return PendingTutors;
    case 'Accepted':
      return AcceptedTutors;
    case 'Rejected':
      return RejectedTutors;
    default:
      return AllTutors;
  }
});
</script>
