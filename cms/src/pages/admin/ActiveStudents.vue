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
          @click="currentTab = 'Unflagged'"
          :class="currentTab === 'Unflagged' ? 'font-bold underline' : ''"
        >
          Unflagged
        </button>
        <button
          @click="currentTab = 'Warned'"
          :class="currentTab === 'Warned' ? 'font-bold underline' : ''"
        >
          Warned
        </button>
        <button
          @click="currentTab = 'Penalized'"
          :class="currentTab === 'Penalized' ? 'font-bold underline' : ''"
        >
          Penalized
        </button>
        <button
          @click="currentTab = 'Banned'"
          :class="currentTab === 'Banned' ? 'font-bold underline' : ''"
        >
          Banned
        </button>
      </div>

      <!-- Conditional Rendering of Tab Components -->
      <component :is="currentComponent" :current-tab="currentTab" />
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import SideBar from '@/components/SideBar.vue'
import AllStudents from '@/components/AllStudents.vue';
import UnflaggedStudents from '@/components/UnflaggedStudents.vue';
import WarnedStudents from '@/components/WarnedStudents.vue';
import PenalizedStudents from '@/components/PenalizedStudents.vue';
import BannedStudents from '@/components/BannedStudents.vue';


const currentTab = ref('all')

// Dynamically set the component to load based on the selected tab
const currentComponent = computed(() => {
  switch (currentTab.value) {
    case 'Unflagged':
      return UnflaggedStudents
    case 'Warned':
      return WarnedStudents
    case 'Penalized':
      return PenalizedStudents
    case 'Banned':
      return BannedStudents
    default:
      return AllStudents
  }
})
</script>
