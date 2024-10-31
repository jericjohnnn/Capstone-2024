<template>
  <div class="bg-red-300 p-4">
    <h1 class="text-2xl font-bold mb-4">Resolved Reports</h1>
    <div v-if="loading" class="text-center">Loading reports...</div>
    <div v-else-if="resolvedReports.length === 0" class="text-center">No pending reports available.</div>
    <div v-else>
      <div class="space-y-4">
        <div v-for="report in resolvedReports" :key="report.id" class="bg-white p-4 rounded shadow">
          <div class="flex flex-row gap-x-4 ">
            <div>
              <img :src="report.complainant_profile_image" alt="Profile" class="w-16 h-16 rounded-full mb-2" />
            </div>
            <div class="mr-auto">
              <h2
                class="font-semibold"
                :class="{
                  'text-blue-600': report.complainant_user_type === 'Tutor',
                  'text-green-600': report.complainant_user_type === 'Student'
                }"
              >
                {{ report.complainant_user_type }}
              </h2>
              <h2 class="font-semibold">{{ report.complainant_name }} <span class="font-normal">has filed a complaint</span></h2>
            </div>
            <div class="flex justify-between items-center">
              <button class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 mb-1">View Report</button>
              <p class="ml-4">Status: {{ report.report_status }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="mt-4">
        <button @click="fetchReports" class="bg-blue-500 text-white px-4 py-2 rounded">Refresh Reports</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

const reports = ref([]);
const loading = ref(true);

const fetchReports = async () => {
  loading.value = true;
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/admin/all-reports');
    reports.value = response.data.complainant_report.data;
  } catch (error) {
    console.error('Error fetching reports:', error);
  } finally {
    loading.value = false;
  }
};

// Filter reports to only include those with "Pending" status
const resolvedReports = computed(() => {
  return reports.value.filter(report => report.report_status === 'Resolved');
});

// Fetch reports on component mount
onMounted(fetchReports);
</script>

<style scoped>
/* Add any additional styles here */
</style>
