<template>
  <div class="flex flex-row">
    <SideBar />
    <div class="flex flex-col ml-6 flex-grow">
      <!-- Header Section -->
      <div class="flex items-center py-8">
        <p class="text-4xl font-bold">Tutors Application Dashboard</p>
        <div class="flex items-center ml-[150px]">
          <input
            type="text"
            placeholder="Search tutors..."
            class="px-4 py-2 border border-gray-300 rounded-lg w-[350px] focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <img src="data:image/svg+xml;base64,..." alt="Bell Icon" class="ml-5 w-6 h-6" />
          <div class="ml-5 w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
            <span class="text-white font-bold">P</span>
          </div>
        </div>
      </div>

      <!-- Scrollable Table Section -->
      <div class="overflow-x-auto">
        <div class="flex flex-col w-[130rem] space-y-4 mr-6 ">
          <!-- Header Row with Columns -->
          <div class="flex text-sm font-bold text-gray-700 border-b pb-2 space-x-6">
            <div class="flex-1 text-center">User ID</div>
            <div class="flex-1 text-center">Full Name</div>
            <div class="flex-1 text-center ">Profile Image</div>
            <div class="flex-1 text-center">Address     </div>
            <div class="flex-1 text-center">Contact Number</div>
            <div class="flex-1 text-center">Birthdate</div>
            <div class="flex-1 text-center">Gender</div>
            <div class="flex-1 text-center">Course And Year</div>
            <div class="flex-1 text-center">School ID Number</div>
            <div class="flex-1 text-center">Tutor Rate</div>
            <div class="flex-1 text-center">Offense Status</div>
            <div class="flex-1 text-center">Account Actions</div>
          </div>

          <!-- Tutor Data Rows -->
          <div v-for="tutor in tutors" :key="tutor.id" class="flex text-gray-600 py-2 space-x-6">
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
            <div class="flex-1 text-center">{{ tutor.offense_status }}</div>
            <div class="flex-1 flex-row ">  
             <div class="flex-1 text-center " >
               <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 mb-1">Edit</button>
               <div></div>
              <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Delete</button></div>
             </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axiosInstance from '@/axiosInstance'; // Use the axios instance

import SideBar from './SideBar.vue';

const tutors = ref([]); // Create a reactive reference to hold tutor data

// Function to fetch tutor data from the API
async function fetchTutors() {
  try {
    const response = await axiosInstance.get('/api/admin/all-tutors'); // Use axiosInstance for the API call
    tutors.value = response.data.all_tutors.data; // Assign the response data to tutors
  } catch (error) {
    console.error('Error fetching tutors:', error); // Log any errors
  }
}

// Helper function to format the birthdate
function formatDate(dateString) {
  return new Date(dateString).toLocaleDateString(); // Formats the date to a readable format
}

// Fetch tutors when the component mounts
onMounted(fetchTutors);
</script>
