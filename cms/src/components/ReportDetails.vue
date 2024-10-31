<!-- ReportDetails.vue -->
<template>
  <div class="p-4 bg-white shadow rounded">
    <h2 class="text-xl font-bold mb-4">Report Details</h2>
    <p><strong>Complainant:</strong> {{ report.complainant_name }}</p>
    <p><strong>User Type:</strong> {{ report.complainant_user_type }}</p>
    <p><strong>Status:</strong> {{ report.report_status }}</p>
    <p><strong>Description:</strong> {{ report.description }}</p>
    <!-- Additional report details here -->
    <button @click="$emit('close')" class="mt-4 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
      Close
    </button>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  report: {
    type: Object,
    required: true
  }
});
</script>

<style scoped>
/* Add any additional styles here */
</style>
