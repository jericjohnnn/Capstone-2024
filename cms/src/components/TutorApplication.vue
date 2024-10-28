<template>
  <div class="flex flex-row">
    <AdminPage />
    <div class="flex flex-col ml-6 flex-grow">
      <!-- Header Section -->
      <div class="flex items-center py-8">
        <p class="text-4xl font-bold">Users Dashboard</p>
        <div class="flex items-center ml-auto">
          <!-- Search Input -->
          <input
            type="text"
            placeholder="Search users..."
            class="px-4 py-2 border border-gray-300 rounded-lg w-[350px] focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <img
            src="data:image/svg+xml;base64,..."
            alt="Bell Icon"
            class="ml-5 w-6 h-6"
          />
          <div class="ml-5 w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
            <span class="text-white font-bold">P</span> <!-- Placeholder text or icon -->
          </div>
        </div>
      </div>

      <!-- Scrollable Table Section -->
      <div class="overflow-x-auto">
        <div class="flex flex-col min-w-max space-y-4 mr-6">
          <!-- Header Row with Columns -->
          <div class="flex text-lg font-bold text-gray-700 border-b pb-2 space-x-6">
            <div class="flex-1 text-center">User ID</div>
            <div class="flex-1 text-center">Full Name</div>
            <div class="flex-1 text-center">Profile Image</div>
            <div class="flex-1 text-center">Address</div>
            <div class="flex-1 text-center">Contact Number</div>
            <div class="flex-1 text-center">Birthdate</div>
            <div class="flex-1 text-center">Gender</div>
            <div class="flex-1 text-center">Course</div>
            <div class="flex-1 text-center">Year</div>
            <div class="flex-1 text-center">School ID Number</div>
            <div class="flex-1 text-center">Tutor Rate</div>
            <div class="flex-1 text-center">Contacted Status</div>
            <div class="flex-1 text-center">Approval Status</div>
            <div class="flex-1 text-center">Actions</div>
          </div>

          <!-- User Data Rows -->
          <div v-for="user in users" :key="user.id" class="flex text-gray-600 py-2 space-x-6">
            <div class="flex-1 text-center">{{ user.id }}</div>
            <div class="flex-1 text-center">{{ user.fullName }}</div>
            <div class="flex-1 text-center">
              <img :src="user.profileImage" alt="Profile" class="w-8 h-8 rounded-full mx-auto" />
            </div>
            <div class="flex-1 text-center">{{ user.address }}</div>
            <div class="flex-1 text-center">{{ user.contactNumber }}</div>
            <div class="flex-1 text-center">{{ user.birthdate }}</div>
            <div class="flex-1 text-center">{{ user.gender }}</div>
            <div class="flex-1 text-center">{{ user.course }}</div>
            <div class="flex-1 text-center">{{ user.year }}</div>
            <div class="flex-1 text-center">{{ user.schoolIdNumber }}</div>
            <div class="flex-1 text-center">{{ user.tutorRate }}</div>
            <div class="flex-1 text-center">
              <div 
                @click="toggleContactedStatus" 
                :class="contactedStatus ? 'bg-green-500' : 'bg-gray-300'" 
                class="w-12 h-6 flex items-center rounded-full cursor-pointer transition-colors duration-300 relative"
              >
                <span 
                  :class="contactedStatus ? 'translate-x-6 bg-white' : 'translate-x-0 bg-gray-500'" 
                  class="w-5 h-5 rounded-full transform transition-transform duration-300"
                ></span>
              </div>
            </div>
            <div class="flex-1 text-center">Pending</div>
            <div class="flex-1 text-center">
              <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 mb-1">Accept</button>
              <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Reject</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios'; // Import Axios
import AdminPage from '@/pages/admin/AdminPage.vue';

// Reactive variable to hold user data
const users = ref([]);
const contactedStatus = ref(false);

// Function to fetch users data from API
async function fetchUsers() {
  try {
    const response = await axios.get('/api/admin/all-students'); // Adjust the URL to your API endpoint
    users.value = response.data; // Assume response.data is an array of user objects
  } catch (error) {
    console.error('Error fetching users:', error);
  }
}

// Toggle function for contacted status (example, you might want to implement this differently)
function toggleContactedStatus() {
  contactedStatus.value = !contactedStatus.value;
}

// Fetch users when component mounts
onMounted(fetchUsers);
</script>

