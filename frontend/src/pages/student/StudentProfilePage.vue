<template>
  <main>
    <SideBar>
      <main class="container p-5 mx-auto">
        <div class="bg-gray-200 h-[550px] flex justify-center items-center rounded-xl relative">
          <!-- Profile Image -->
          
          
          <!-- Student info displayed on profile -->
          <div class="bg-gray-100 h-[450px] w-[900px] rounded-lg flex flex-row justify-center items-center space-x-10">
            <img v-if="userData" :src="userData.profile_image" alt="Profile Image" class="  w-60 h-72 object-cover rounded-md border border-gray-400 shadow-md" />
            <div class="flex flex-col">
              <div class="flex items-center flex-col text-gray-600">
              <p class="text-4xl  font-bold capitalize"><span class="font-normal">Hi! I'm</span> {{ userData?.first_name }} {{ userData?.last_name }}</p>
              <p><span class="font-normal ">Grade Level:</span> <span class="text-md  font-medium capitalize">{{ userData?.grade_year }}</span></p>
            </div>
            <div class="mt-5 text-md space-y-2 text-gray-600">
              <p><span class="font-normal">Contact Number:</span> <span class="font-medium">{{ userData?.contact_number }}</span></p>
              <p><span class="font-normal">School ID Number:</span> <span class="font-medium">{{ userData?.school_id_number }}</span></p>
              <p><span class="font-normal">Address:</span> <span class="font-medium capitalize">{{ userData?.address }}</span></p>
              <p><span class="font-normal">Birthdate:</span> <span class="font-medium">{{ userData?.birthdate }}</span></p>
              <p><span class="font-normal">Offense Status:</span> <span class="font-medium">{{ userData?.offense_status }}</span></p>
            </div>
            <div class="space-x-4 mt-4">
              <button @click="openDeleteModal" class="px-4 rounded-md border border-red-600 text-red-600 py-2 ">Delete Account</button>
              <button @click="toggleEditMode" class="px-12 rounded-md bg-blue-600 text-white py-2">Edit</button>
            </div>
            </div>
          </div>
        </div>
      </main>
    </SideBar>

    <HelpButton />
  </main>

  <!-- Edit Profile Modal -->
  <div v-if="isEditModalVisible" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center z-10">
  <div class="bg-white p-6 rounded-md shadow-lg w-full max-w-md overflow-hidden">
    <h3 class="text-xl mb-4 text-center font-medium">Edit Profile</h3>
    <form @submit.prevent="saveEdits">
      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label for="first_name" class="block text-gray-700">First Name</label>
          <input v-model="editData.first_name" type="text" id="first_name" class="w-full mt-1 px-3 py-2 border rounded-md text-sm" />
        </div>
        <div>
          <label for="last_name" class="block text-gray-700">Last Name</label>
          <input v-model="editData.last_name" type="text" id="last_name" class="w-full mt-1 px-3 py-2 border rounded-md text-sm" />
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label for="address" class="block text-gray-700">Address</label>
          <input v-model="editData.address" type="text" id="address" class="w-full mt-1 px-3 py-2 border rounded-md text-sm" />
        </div>
        <div>
          <label for="birthdate" class="block text-gray-700">Birthdate</label>
          <input v-model="editData.birthdate" type="date" id="birthdate" class="w-full mt-1 px-3 py-2 border rounded-md text-sm" />
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label for="contact_number" class="block text-gray-700">Contact Number</label>
          <input v-model="editData.contact_number" type="text" id="contact_number" class="w-full mt-1 px-3 py-2 border rounded-md text-sm" />
        </div>
        <div>
          <label for="school_id_number" class="block text-gray-700">School ID Number</label>
          <input v-model="editData.school_id_number" type="text" id="school_id_number" class="w-full mt-1 px-3 py-2 border rounded-md text-sm" />
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label for="grade_year" class="block text-gray-700">Grade Year</label>
          <input v-model="editData.grade_year" type="text" id="grade_year" class="w-full mt-1 px-3 py-2 border rounded-md text-sm" />
        </div>
      </div>

      <div class="flex justify-between space-x-4 mt-6">
        <button @click="toggleEditMode" type="button" class="bg-gray-400 text-white px-6 py-2 rounded-md text-sm">Cancel</button>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md text-sm">Save</button>
      </div>
    </form>
  </div>
</div>


  <!-- Confirmation Modal -->
  <div v-if="isDeleteModalVisible" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center z-10">
    <div class="bg-white p-5 rounded-md shadow-lg w-96">
      <h3 class="text-xl mb-4 text-center">Are you sure you want to delete your account?</h3>
      <p class="text-center text-gray-600 mb-4">This action is irreversible, and all your data will be lost.</p>
      <div class="flex justify-center space-x-4">
        <button @click="deleteAccount" class="bg-red-600 text-white px-6 py-2 rounded-md">Yes, Delete</button>
        <button @click="closeDeleteModal" class="bg-gray-400 text-white px-6 py-2 rounded-md">Cancel</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axiosInstance from '@/axiosInstance' // Adjust based on your Axios configuration
import SideBar from '@/components/SideBar.vue'
import HelpButton from '@/components/HelpButton.vue'

// Reactive variables
const userData = ref(null)
const isEditModalVisible = ref(false)
const isDeleteModalVisible = ref(false)
const editData = ref({
  first_name: '',
  last_name: '',
  birthdate: '',
  address: '',
  contact_number: '',
  school_id_number: '',
  grade_year: ''
})
const router = useRouter()

// Fetch student data (retrieve from localStorage)
const fetchStudentData = () => {
  const storedUserData = localStorage.getItem('user_data')
  if (storedUserData) {
    userData.value = JSON.parse(storedUserData)
    // Set initial edit data with current user data
    editData.value = { ...userData.value }
  } else {
    console.error('No student data found in local storage')
  }
}

// Fetch student data when the component is mounted
onMounted(fetchStudentData)

// Open the edit modal
const toggleEditMode = () => {
  isEditModalVisible.value = !isEditModalVisible.value
}

// Save the edited profile data
const saveEdits = () => {
  // Update user data with the changes
  userData.value = { ...editData.value }

  // Save updated user data to localStorage
  localStorage.setItem('user_data', JSON.stringify(userData.value))

  // Optionally, send the updated data to the backend for saving
  axiosInstance.put('/api/update-student', userData.value) // Replace with your API endpoint

  // Close the modal
  toggleEditMode()
}

// Open the delete confirmation modal
const openDeleteModal = () => {
  isDeleteModalVisible.value = true
}

// Close the delete confirmation modal
const closeDeleteModal = () => {
  isDeleteModalVisible.value = false
}

// Delete the account, clear localStorage, logout, and redirect
const deleteAccount = async () => {
  try {
    // Optional: Call backend API to delete the user account from the database
    await axiosInstance.delete('/api/delete-student-account') // Replace with your API endpoint

    // Clear user data from localStorage and sessionStorage
    localStorage.removeItem('user_data')
    localStorage.removeItem('student_data') // Removes user profile data
    localStorage.removeItem('app_auth_token')
    localStorage.removeItem('user_email')
    localStorage.removeItem('user_full_name')
    localStorage.removeItem('user_type') // Removes authentication token
    sessionStorage.clear() // Clears sessionStorage if used

    // Log out the user by clearing session and redirecting
    router.push('/') // Redirect to home page or login page

  } catch (error) {
    console.error("Error deleting account:", error)
  }
}
</script>

<style scoped>
/* Optional: Style for modal form and other elements */
</style>
