<template>
  <div class="flex justify-center m-2">
    <div class="flex flex-col w-[68rem] space-y-2 justify-center items-center">
      <!-- Header Row with Columns -->
      <div class="flex font-bold text-gray-700 bg-red-200 justify-center rounded-md border-b py-2 space-x-3 w-full">
        <div class="w-10 text-center">User ID</div>
        <div class="w-28 text-center">Full Name</div>
        <div class="w-16 text-center">Profile Image</div>
        <div class="w-32 text-center">Address</div>
        <div class="w-32 text-center">Contact Number</div>
        <div class="w-28 text-center">Birthdate</div>
        <div class="w-20 text-center">Gender</div>
        <div class="w-32 text-center">Course And Year</div>
        <div class="w-28 text-center">School ID Number</div>
        <div class="w-20 text-center">Tutor Rate</div>
        <div class="w-28 text-center">Offense Status</div>
        <div class="w-32 text-center">Account Actions</div>
      </div>

      <!-- Scrollable Tutor Data Rows Container -->
      <div class="overflow-y-auto max-h-[400px] w-full">
        <div v-for="tutor in tutors" :key="tutor.id" class="flex text-gray-600 py-2 space-x-3 w-full border-2 rounded-md bg-blue-200">
          <div class="w-10 text-center">{{ tutor.user_id }}</div>
          <div class="w-28 text-center">{{ tutor.first_name }} {{ tutor.last_name }}</div>
          <div class="w-16 text-center">
            <img :src="tutor.profile_image" alt="Profile" class="w-8 h-8 rounded-full mx-auto" />
          </div>
          <div class="w-32 text-center">{{ tutor.address }}</div>
          <div class="w-32 text-center">{{ tutor.contact_number }}</div>
          <div class="w-28 text-center">{{ formatDate(tutor.birthdate) }}</div>
          <div class="w-20 text-center">{{ tutor.gender }}</div>
          <div class="w-32 text-center">{{ tutor.course }} {{ tutor.year }}</div>
          <div class="w-28 text-center">{{ tutor.school_id_number }}</div>
          <div class="w-20 text-center">{{ tutor.tutor_rate }}</div>
          <div class="w-28 text-center">{{ tutor.offense_status }}</div>
          <div class="w-32 text-center">
            <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 mb-1">Edit</button>
            <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Delete</button>
          </div>
        </div>
      </div>

      <!-- Pagination Controls -->
      <div class="flex justify-center space-x-2 w-full mt-4">
        <button 
          @click="prevPage" 
          :disabled="currentPage === 1" 
          class="bg-blue-500 text-white px-3 flex justify-center items-center rounded-md hover:bg-blue-600 disabled:opacity-50">
          <span class="text-lg">&lt;</span>
        </button>
        <span class="flex items-center">Page {{ currentPage }} of {{ totalPages }}</span>
        <button 
          @click="nextPage" 
          :disabled="currentPage === totalPages" 
          class="bg-blue-500 text-white px-3 flex justify-center items-center rounded-md hover:bg-blue-600 disabled:opacity-50">
          <span class="text-lg">&gt;</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axiosInstance from '@/axiosInstance';

const tutors = ref([]);
const currentPage = ref(1);
const totalPages = ref(0);
const itemsPerPage = 8;

// Fetch tutors and filter to include only "Accepted" ones
async function fetchTutors() {
  try {
    const response = await axiosInstance.get('/api/admin/all-tutors');
    const acceptedTutors = response.data.all_tutors.data.filter(
      tutor => tutor.approval_status === 'Accepted' && (tutor.offense_status === 'Warned' || !tutor.offense_status)
    );
    tutors.value = acceptedTutors;
    totalPages.value = Math.ceil(acceptedTutors.length / itemsPerPage);
  } catch (error) {
    console.error('Error fetching tutors:', error);
  }
}


// Computed property to handle paginated "Accepted" tutors only
const paginatedTutors = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  return tutors.value.slice(start, start + itemsPerPage);
});

function prevPage() {
  if (currentPage.value > 1) {
    currentPage.value -= 1;
  }
}

function nextPage() {
  if (currentPage.value < totalPages.value) {
    currentPage.value += 1;
  }
}

function formatDate(dateString) {
  return new Date(dateString).toLocaleDateString();
}

// Toggle Contacted Status
async function toggleContactedStatus(tutor) {
  try {
    const newStatus = !tutor.contacted_status;
    await axiosInstance.patch(`/api/admin/contacted-status/${tutor.id}`, {
      contacted_status: newStatus,
    });
    tutor.contacted_status = newStatus;
  } catch (error) {
    console.error('Error updating contacted status:', error);
  }
}

onMounted(fetchTutors);
</script>
