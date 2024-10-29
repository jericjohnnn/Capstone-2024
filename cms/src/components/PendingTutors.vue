<template>
  <div class="flex flex-row">
    <!-- Scrollable Table Section -->
    <div class="overflow-x-auto">
      <div class="flex flex-col w-[70rem] space-y-4 mr-6">
        <!-- Header Row with Columns -->
        <div class="flex text-sm font-bold text-gray-700 border-b pb-2 space-x-6">
          <div class="flex-1 text-center">User ID</div>
          <div class="flex-1 text-center">Full Name</div>
          <div class="flex-1 text-center">Profile Image</div>
          <div class="flex-1 text-center">Address</div>
          <div class="flex-1 text-center">Contact Number</div>
          <div class="flex-1 text-center">Birthdate</div>
          <div class="flex-1 text-center">Gender</div>
          <div class="flex-1 text-center">Course And Year</div>
          <div class="flex-1 text-center">School ID Number</div>
          <div class="flex-1 text-center">Tutor Rate</div>
          <div class="flex-1 text-center">Contacted Status</div>
          <div class="flex-1 text-center">Approval Status</div>
          <div class="flex-1 text-center">Actions</div>
        </div>

        <!-- Tutor Data Rows -->
        <div v-for="tutor in filteredTutors" :key="tutor.id" class="flex text-gray-600 py-2 space-x-6">
          <div class="flex-1 text-center">{{ tutor.user_id }}</div>
          <div class="flex-1 text-center">{{ tutor.first_name }} {{ tutor.last_name }}</div>
          <div class="flex-1 text-center">
            <img :src="tutor.profile_image" alt="Profile" class="w-8 h-8 rounded-full mx-auto" />
          </div>
          <div class="flex-1 text-center">{{ tutor.address }}</div>
          <div class="flex-1 text-center">{{ tutor.contact_number }}</div>
          <div class="flex-1 text-center">{{ formatDate(tutor.birthdate) }}</div>
          <div class="flex-1 text-center">{{ tutor.gender }}</div>
          <div class="flex-1 text-center">{{ tutor.course }} {{ tutor.year }}</div>
          <div class="flex-1 text-center">{{ tutor.school_id_number }}</div>
          <div class="flex-1 text-center">{{ tutor.tutor_rate }}</div>
          <div class="flex-1 text-center">
            <button
              @click="toggleContactedStatus(tutor)"
              :class="tutor.contacted_status ? 'bg-green-500' : 'bg-gray-500'"
              class="text-white px-2 py-1 rounded hover:bg-opacity-75"
            >
              {{ tutor.contacted_status ? 'Contacted' : 'Not Contacted' }}
            </button>
          </div>

          <div class="flex-1 text-center">{{ tutor.approval_status }}</div>
          <div class="flex-1 text-center">
            <div v-if="tutor.approval_status === 'Pending'">
              <button @click="acceptTutor(tutor.id)" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 mb-1">Accept</button>
              <div></div>
              <button @click="rejectTutor(tutor.id)" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Reject</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axiosInstance from '@/axiosInstance';

const tutors = ref([]);
const currentTab = ref('pending'); // Set the default tab to 'pending'

async function fetchTutors() {
  try {
    const response = await axiosInstance.get('/api/admin/all-tutors');
    tutors.value = response.data.all_tutors.data;
  } catch (error) {
    console.error('Error fetching tutors:', error);
  }
}

// Computed property to filter tutors to only show those with 'Pending' status
const filteredTutors = computed(() => {
  return tutors.value.filter(tutor => tutor.approval_status === 'Pending');
});

function formatDate(dateString) {
  return new Date(dateString).toLocaleDateString();
}

async function acceptTutor(tutorId) {
  try {
    await axiosInstance.patch(`/api/admin/approval-status/${tutorId}`, {
      approval_status: 'Accepted',
    });
    updateTutorStatus(tutorId, 'Accepted');
  } catch (error) {
    console.error('Error accepting tutor:', error);
  }
}

// Method to reject a tutor and move them to the end of the list
async function rejectTutor(tutorId) {
  try {
    await axiosInstance.patch(`/api/admin/approval-status/${tutorId}`, {
      approval_status: 'Rejected',
    });
    updateTutorStatus(tutorId, 'Rejected');
  } catch (error) {
    console.error('Error rejecting tutor:', error);
  }
}

// Helper function to update tutor status in the local array
function updateTutorStatus(tutorId, newStatus) {
  const tutorIndex = tutors.value.findIndex((t) => t.id === tutorId);
  if (tutorIndex !== -1) {
    const tutor = tutors.value.splice(tutorIndex, 1)[0];
    tutor.approval_status = newStatus;
    tutors.value.push(tutor); // Move to the end of the list if needed
  }
}

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
