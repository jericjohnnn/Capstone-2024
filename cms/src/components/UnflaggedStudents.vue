<template>
  <div class="flex flex-col">
    <div class="flex flex-row mb-4">
      <div class="flex flex-col ml-6 flex-grow">
        <!-- Scrollable Table Section -->
       
          <div class="flex flex-col w-[68rem] space-y-2 mr-6">
            <!-- Header Row with Columns -->
            <div class="flex font-bold text-gray-700 bg-red-200 justify-between rounded-md border-b py-2 space-x-3">
              <div class="w-10 text-center">User ID</div>
              <div class="w-28 text-center">Full Name</div>
              <div class="w-16 text-center">Profile Image</div>
              <div class="w-32 text-center">Address</div>
              <div class="w-32 text-center">Contact Number</div>
              <div class="w-28 text-center">Birthdate</div>
              <div class="w-28 text-center">Offense Status</div>
              <div class="w-32 text-center">Actions</div>
            </div>

            <div class="overflow-y-auto max-h-[400px] w-[69rem]">
                <div v-for="student in paginatedStudents" :key="student.id" class="flex text-gray-600 justify-between py-2 space-x-3 w-full border-2 rounded-md bg-blue-200">
              <div class="w-10 text-center">{{ student.user_id }}</div>
              <div class="w-28 text-center">{{ student.first_name }} {{ student.last_name }}</div>
              <div class="w-16 text-center">
                <img :src="student.profile_image" alt="Profile" class="w-8 h-8 rounded-full mx-auto" />
              </div>
              <div class="w-32 text-center">{{ student.address }}</div>
              <div class="w-32 text-center">{{ student.contact_number }}</div>
              <div class="w-28 text-center">{{ formatDate(student.birthdate) }}</div>
              <div class="w-28 text-center">{{ student.offense_status }}</div>
              <div class="w-32 text-center">
                <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 mb-1">Edit</button>
                <div></div>
                <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Delete</button>
              </div>
            </div>
            </div>
        </div>
      </div>
    </div>

    <!-- Pagination Controls -->
    <div class="flex justify-center space-x-2 w-full mt-2">
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
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axiosInstance from '@/axiosInstance'; // Use the axios instance

const students = ref([]); // Create a reactive reference to hold student data
const studentsPerPage = 10; // Number of students to display per page
const currentPage = ref(1); // Current page number

// Function to fetch student data from the API
async function fetchStudents() {
  try {
    const response = await axiosInstance.get('/api/admin/all-students'); // Use axiosInstance for the API call
    // Filter to get only students with Unflagged offense status
    students.value = response.data.all_students.data.filter(
      student => student.offense_status === 'Unflagged'
    ); 
  } catch (error) {
    console.error('Error fetching students:', error); // Log any errors
  }
}

// Helper function to format the birthdate
function formatDate(dateString) {
  return new Date(dateString).toLocaleDateString(); // Formats the date to a readable format
}

// Computed property to get the paginated students
const paginatedStudents = computed(() => {
  const start = (currentPage.value - 1) * studentsPerPage;
  return students.value.slice(start, start + studentsPerPage);
});

// Computed property to calculate total pages
const totalPages = computed(() => {
  return Math.ceil(students.value.length / studentsPerPage);
});

// Fetch students when the component mounts
onMounted(fetchStudents);
</script>
