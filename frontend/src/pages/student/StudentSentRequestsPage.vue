<template>
  <main class="bg-blue-200">
    <SideBar>
      <div class="container mx-auto">
        <div class="flex justify-center font-bold text-2xl py-4">
          Tutor Request
        </div>
        
        <!-- Tab Buttons -->
        <div class="flex  space-x-2 mb-2">
          <button 
            class="p-2 font-semibold rounded-md"
            :class="selectedTab === 'all' ? 'font-bold underline text-black ' : 'font-normal'"
            @click="selectedTab = 'all'">
            All Requests
          </button>
          <button 
            class="p-2 font-semibold rounded-md"
            :class="selectedTab === 'pending' ? 'font-bold underline text-black ' : 'font-normal'"
            @click="selectedTab = 'pending'">
            Pending Requests
          </button>
          <button 
            class="p-2 font-semibold rounded-md"
            :class="selectedTab === 'completed' ? 'font-bold underline text-black ' : 'font-normal'"
            @click="selectedTab = 'completed'">
            Completed Requests
          </button>
        </div>

        <!-- Tab Content -->
        <div class="flex justify-center bg-white rounded-xl h-[460px] overscroll-y-auto">
          <div class="flex flex-col pt-2 space-y-4">
             <component :is="currentTabComponent" />
          </div>
        </div>
      </div>
    </SideBar>
    <HelpButton />
  </main>
</template>

<script setup>
import { ref, computed } from 'vue'
import SideBar from '@/components/SideBar.vue'
import HelpButton from '@/components/HelpButton.vue'
import AllTutorRequest from '@/components/AllTutorRequest.vue'
import PendingTutorRequest from '@/components/PendingTutorRequest.vue'
import CompletedTutorRequest from '@/components/CompletedTutorRequest.vue'

const selectedTab = ref('all')

// Computed property to switch components based on selectedTab
const currentTabComponent = computed(() => {
  switch (selectedTab.value) {
    case 'pending':
      return PendingTutorRequest
    case 'completed':
      return CompletedTutorRequest
    default:
      return AllTutorRequest
  }
})
</script>
