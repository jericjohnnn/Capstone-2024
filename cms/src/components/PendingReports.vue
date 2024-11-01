<template>
  <div class="bg-red-300 p-4">
    <!-- Breadcrumb-like tabs -->
    <div class="flex space-x-2 mb-4">
      <button
        @click="showListView"
        :class="{
          'text-blue-600 font-semibold underline': currentView === 'list',
        }"
        class="text-gray-600 hover:text-blue-600"
      >
        Pending Reports
      </button>
      <button
        v-if="currentView === 'details'"
        @click="showDetailsView"
        :class="{
          'text-blue-600 font-semibold underline': currentView === 'details',
        }"
        class="text-gray-600 hover:text-blue-600"
      >
        <span>/</span>
        Report Details
      </button>
    </div>

    <!-- Content based on view -->
    <div v-if="currentView === 'list'">
      <div v-if="loading" class="text-center">Loading reports...</div>
      <div v-else-if="pendingReports.length === 0" class="text-center">
        No pending reports available.
      </div>
      <div v-else class="space-y-4">
        <div v-for="report in pendingReports" :key="report.id" class="bg-white p-4 rounded shadow">
          <div class="flex flex-row gap-x-4">
            <img :src="report.complainant_profile_image" alt="Profile" class="w-16 h-16 rounded-full mb-2" />
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
            <div class="flex items-center">
              <button @click="goToReportDetails(report)" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 mb-1">View Report</button>
              <p class="ml-4">Status: {{ report.report_status }}</p>
            </div>
          </div>
        </div>
        <div class="mt-4">
          <button @click="fetchReports" class="bg-blue-500 text-white px-4 py-2 rounded">Refresh Reports</button>
        </div>
      </div>
    </div>

    <div v-else-if="currentView === 'details'">
      <!-- Report Details View -->
      <div v-if="selectedReport" class="p-4 bg-white shadow rounded">
        <div class="flex flex-row">
          <div class="bg-blue-300 w-[400px] p-4 space-y-[100px]">
            <div class="mb-4">
              <div class="flex flex-row">
                <div class="mr-2">
                  <img :src="selectedReport.complainant_profile_image" alt="Complainant Profile" class="w-16 h-16 rounded-md mb-2" />
                </div>
                <div>
                  <p><strong>Complainant:</strong> {{ selectedReport.complainant_name }}</p>
                  <p><strong>User Type:</strong> {{ selectedReport.complainant_user_type }}</p>
                </div>
              </div>
              <p><strong>Status:</strong> {{ selectedReport.report_status }}</p>
            </div>
            <div class="mb-4">
              <div class="flex flex-row mt-4">
                <div class="mr-2">
                  <img :src="selectedReport.offender_profile_image" alt="Offender Profile" class="w-16 h-16 rounded-md mb-2" />
                </div>
                <div>
                  <p><strong>Offender:</strong> {{ selectedReport.offender_name }}</p>
                  <p><strong>User Type:</strong> {{ selectedReport.offender_user_type }}</p>
                </div>
              </div>
              <p><strong>Offense Status:</strong> {{ selectedReport.offender_offense_status }}</p>
              <p><strong>Contact Number:</strong> {{ selectedReport.offender_contact_number }}</p>
              <p><strong>Address:</strong> {{ selectedReport.offender_address }}</p>
            </div>
            <div>
              <button class="bg-red-800 text-white px-2 py-1 rounded hover:bg-red-800 mb-1">Warn</button>
              <button class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Penalize</button>
              <button class="bg-red-400 text-white px-2 py-1 rounded hover:bg-red-500">Ban</button>
            </div>
          </div>
          <div>
            <p class="text-lg font-semibold mb-2"><strong>Subject: </strong>{{ selectedReport.report_title }}</p>
            <p><strong>Message:</strong> {{ selectedReport.report_message }}</p>
          </div>
        </div>
        <button @click="showListView" class="mt-4 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back to Reports</button>
      </div>
      <div v-else class="text-center">Loading report details...</div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

const reports = ref([]);
const loading = ref(true);
const currentView = ref('list');
const selectedReport = ref(null);

// Fetch reports from the API
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
const pendingReports = computed(() => {
  return reports.value.filter(report => report.report_status === 'Pending');
});

// Navigate to report details
const goToReportDetails = async (report) => {
  loading.value = true;
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/admin/${report.id}`);
    selectedReport.value = response.data.report_data;
    currentView.value = 'details';
  } catch (error) {
    console.error('Error fetching report details:', error);
  } finally {
    loading.value = false;
  }
};

// Show the list view
const showListView = () => {
  currentView.value = 'list';
  selectedReport.value = null;
};

// Fetch reports on component mount
onMounted(fetchReports);
</script>

<style scoped>
/* Add any additional styles here */
</style>
