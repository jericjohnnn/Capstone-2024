<template>
  <div class="border-b border-gray-200 dark:border-neutral-700">
    <nav
      class="flex gap-x-4 overflow-x-auto scrollbar-hide"
      aria-label="Tabs"
      role="tablist"
      aria-orientation="horizontal"
    >
      <button
        type="button"
        :class="{
          'font-medium text-blue-600 border-b-2 border-blue-600':
            currentTab === 'pending',
          'text-gray-500 hover:text-blue-600 transition-colors':
            currentTab !== 'pending',
        }"
        @click="switchTab('pending')"
        role="tab"
        aria-selected="currentTab === 'pending'"
      >
        Pending
      </button>

      <button
        type="button"
        :class="{
          'font-medium text-blue-600 border-b-2 border-blue-600':
            currentTab === 'completed',
          'text-gray-500 hover:text-blue-600 transition-colors':
            currentTab !== 'completed',
        }"
        @click="switchTab('completed')"
        role="tab"
        aria-selected="currentTab === 'completed'"
      >
        Completed
      </button>
    </nav>
  </div>

  <div class="mt-6">
    <div v-show="currentTab === 'pending'">
      <slot name="pending"></slot>
    </div>
    <div v-show="currentTab === 'completed'">
      <slot name="completed"></slot>
    </div>
  </div>
</template>
<script setup>
import { ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()
const currentTab = ref(route.query.tab || 'pending')

const switchTab = tabName => {
  currentTab.value = tabName

  router.push({
    path: '/tutor/requests',
    query: { tab: tabName },
  })
}
</script>
