<template>
  <div class="flex flex-row">
    <SideBar />
    <div class="flex flex-col flex-grow">
      <!-- Header Section -->
      <div class="flex items-center py-4 border-b mb-4 justify-between">
        <div class="flex items-center ml-6">
          <input
            type="text"
            placeholder="Search tutors..."
            class="px-4 border border-gray-300 rounded-lg w-[350px] h-9 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
          />
        </div>
        <div class="flex flex-row items-center mr-6">
          <img
            src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9ImN1cnJlbnRDb2xvciIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiIGNsYXNzPSJsdWNpZGUgbHVjaWRlLWJlbGwiPjxwYXRoIGQ9Ik02IDhhNiA2IDAgMCAxIDEyIDBjMCA3IDMgOSAzIDlIM3MzLTItMy05Ii8+PHBhdGggZD0iTTEwLjMgMjFhMS45NCAxLjk0IDAgMCAwIDMuNCAwIi8+PC9zdmc+"
            alt="Bell Icon"
            class="ml-5 w-6 h-6"
          />

          <div
            class="ml-5 w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center"
          >
            <span class="text-slate-700 font-bold">P</span>
          </div>
        </div>
      </div>
      <!-- Breadcrumb Tabs -->
      <div class="flex space-x-4 mb-3 ml-6 text-lg font-bold">
        <button
          @click="currentTab = 'all'"
          :class="currentTab === 'all' ? 'font-bold underline' : ''"
        >
          All
        </button>
        <button
          @click="currentTab = 'Pending'"
          :class="currentTab === 'Pending' ? 'font-bold underline' : ''"
        >
          Pending
        </button>
        <button
          @click="currentTab = 'Accepted'"
          :class="currentTab === 'Accepted' ? 'font-bold underline' : ''"
        >
          Accepted
        </button>
        <button
          @click="currentTab = 'Rejected'"
          :class="currentTab === 'Rejected' ? 'font-bold underline' : ''"
        >
          Rejected
        </button>
      </div>

      <!-- Conditional Rendering of Tab Components -->
      <component :is="currentComponent" :current-tab="currentTab" />
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'


import AllApplicants from '@/components/AllApplicants.vue'
import SideBar from '@/components/SideBar.vue'
import PendingTutors from '@/components/PendingTutors.vue';
import AcceptedTutors from '@/components/AcceptedTutors.vue';
import RejectedTutors from '@/components/RejectedTutors.vue';

const currentTab = ref('all')

// Dynamically set the component to load based on the selected tab
const currentComponent = computed(() => {
  switch (currentTab.value) {
    case 'Pending':
      return PendingTutors
    case 'Accepted':
      return AcceptedTutors
    case 'Rejected':
      return RejectedTutors
    default:
      return AllApplicants
  }
})
</script>
