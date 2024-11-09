<template>
  <main>
    <SideBar>
      <main class="container p-5 mx-auto">
        
        <div class="bg-red-200 h-[550px] flex justify-center items-end rounded-xl relative">
          <!-- Image positioned above the blue background, with a check for studentData -->
          <img v-if="studentData" :src="studentData.profile_image" alt="Profile Image" class="absolute top-7 w-32 h-32 object-cover rounded-full border-4 border-white shadow-md" />

          <!-- Blue background div centered below the image -->
          <div class="bg-blue-200 h-[450px] w-[600px] rounded-lg flex flex-col justify-start items-center pt-20">
            <div class="flex items-center flex-col">
              <p class="text-4xl text-gray-600 font-bold">{{ studentData?.last_name }}, {{ studentData?.first_name }}</p>
              <p class="text-md text-gray-600 font-semibold"> {{ studentData?.address }}</p>
            </div>
            <div class="mt-5 text-md space-y-1 text-gray-600">
              <p><strong>Birthdate:</strong> {{ studentData?.birthdate }}</p>
              <p><strong>Contact Number:</strong> {{ studentData?.contact_number }}</p>
              <p><strong>School ID Number:</strong> {{ studentData?.school_id_number }}</p>
              <p><strong>Grade Year:</strong> {{ studentData?.grade_year }}</p>
              <p><strong>Offense Status:</strong> {{ studentData?.offense_status }}</p>
            </div>
            <div class="space-x-5 mt-4">
              <button @click="openEditModal" class="px-6 py-2 bg-blue-600 rounded-md hover:bg-blue-500">Edit</button>
              <button @click="deleteStudent" class="px-6 py-2 bg-red-600 rounded-md hover:bg-red-500">Delete</button>
            </div>
          </div>
        </div>

      </main>
    </SideBar>

    <HelpButton />
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axiosInstance from '@/axiosInstance' // Adjust based on your Axios configuration
import SideBar from '@/components/SideBar.vue'
import HelpButton from '@/components/HelpButton.vue'

// Reactive variables
const studentData = ref(null)
const isEditModalOpen = ref(false)
const editData = ref({
  address: '',
  contact_number: '',
  profile_image: null,
})

// Function to retrieve the Authorization token
const getAuthToken = () => {
  return localStorage.getItem('token') // Assuming the token is stored in localStorage
}

// Fetch student data
async function fetchStudentData() {
  try {
    const response = await axiosInstance.get('/api/student-info', {
      headers: {
        'Authorization': `Bearer ${getAuthToken()}`, // Add Authorization header
      },
      withCredentials: true, // Add this if you are using cookies for authentication
    })
    studentData.value = response.data.student
  } catch (error) {
    console.error('Error fetching student data:', error)
    if (error.response && error.response.status === 401) {
      // Handle unauthorized error (e.g., prompt user to log in again)
    }
  }
}

// Open edit modal
function openEditModal() {
  editData.value = { ...studentData.value } // Copy current data into edit form
  isEditModalOpen.value = true
}

// Close edit modal
function closeEditModal() {
  isEditModalOpen.value = false
}

// Handle image change
function handleImageChange(event) {
  editData.value.profile_image = event.target.files[0]
}

// Submit form and update student details
async function submitEditForm() {
  try {
    const formData = new FormData()
    formData.append('address', editData.value.address)
    formData.append('contact_number', editData.value.contact_number)
    if (editData.value.profile_image) {
      formData.append('profile_image', editData.value.profile_image)
    }

    const response = await axiosInstance.put('/api/edit-student-details', formData, {
      headers: {
        'Authorization': `Bearer ${getAuthToken()}`, // Add Authorization header
        'Content-Type': 'multipart/form-data',
      },
      withCredentials: true, // Add this if you are using cookies for authentication
    })

    studentData.value = response.data.student // Update the student data in the UI
    closeEditModal() // Close modal after success
  } catch (error) {
    console.error('Error updating student details:', error)
  }
}

// Delete student account
async function deleteStudent() {
  try {
    await axiosInstance.delete('/api/delete-student-account', {
      headers: {
        'Authorization': `Bearer ${getAuthToken()}`, // Add Authorization header
      },
      withCredentials: true, // Add this if you are using cookies for authentication
    })
    // Handle any post-deletion actions (e.g., redirecting user, showing success message)
  } catch (error) {
    console.error('Error deleting student:', error)
  }
}

// Fetch student data on mount
onMounted(fetchStudentData)
</script>
