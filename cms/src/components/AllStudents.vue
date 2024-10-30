<template>
  <div class="flex flex-row">
    
    <div class="flex flex-col ml-6 flex-grow">
      
      
      <!-- Scrollable Table Section -->
      <div class="overflow-x-auto">
        <div class="flex flex-col w-[130rem] space-y-4 mr-6 ">
          <!-- Header Row with Columns -->
          <div class="flex text-sm font-bold text-gray-700 border-b pb-2 space-x-6">
            <div class="flex-1 text-center">User ID</div>
            <div class="flex-1 text-center">Full Name</div>
            <div class="flex-1 text-center ">Profile Image</div>
            <div class="flex-1 text-center">Address</div>
            <div class="flex-1 text-center">Contact Number</div>
            <div class="flex-1 text-center">Birthdate</div>
            <div class="flex-1 text-center">Offense Status</div>
            <div class="flex-1 text-center">Actions</div>
          </div>

          <!-- student Data Rows -->
          <div v-for="student in students" :key="student.id" class="flex text-gray-600 py-2 space-x-6">
            <div class="flex-1 text-center">{{ student.user_id }}</div>
            <div class="flex-1 text-center">{{ student.first_name }} {{ student.last_name }}</div>
            <div class="flex-1 text-center">
              <img :src="student.profile_image" alt="Profile" class="w-8 h-8 rounded-full mx-auto" />
            </div>
            <div class="flex-1 text-center">{{ student.address }}</div>
            <div class="flex-1 text-center">{{ student.contact_number }}</div>
            <div class="flex-1 text-center">{{ formatDate(student.birthdate) }}</div>
            <div class="flex-1 text-center">{{ student.offense_status }}</div>
            <div class="flex-1 text-center">  
              <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 mb-1">Accept</button>
              <div></div>
              <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Reject</button></div>
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

const students = ref([]); // Create a reactive reference to hold student data

// Function to fetch student data from the API
async function fetchStudents() {
  try {
    const response = await axiosInstance.get('/api/admin/all-students'); // Use axiosInstance for the API call
    students.value = response.data.all_students.data; // Assign the response data to students
  } catch (error) {
    console.error('Error fetching students:', error); // Log any errors
  }
}

// Helper function to format the birthdate
function formatDate(dateString) {
  return new Date(dateString).toLocaleDateString(); // Formats the date to a readable format
}

// Fetch students when the component mounts
onMounted(fetchStudents);
</script>
