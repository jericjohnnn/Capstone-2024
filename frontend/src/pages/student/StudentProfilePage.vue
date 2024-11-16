<template>
  <main>
    <SideBar>
      <main class="container p-5 mx-auto">
        <p class="font-semibold text-xl">Account Information</p>
        <div class="  h-[850px]  flex flex-col  items-center rounded-xl relative">
          <!-- Profile Image -->
        <div class="w-full border font-normal text-gray-600 bg-gray-200 border-neutral-400 rounded">
  <!-- Personal Information Section -->
  <div class="px-7 py-4 border-b text-gray-700 border-neutral-400 font-semibold flex justify-between items-center">
    Personal Information
  </div>
  <div class="px-7 py-4 border-b border-neutral-400 text-xs">
    The information provided below will reflect on your invoices
  </div>

  <!-- Grid container for the data rows -->
 
  <!-- Grid Row for Name -->
  <div class="grid grid-cols-2 gap-4 py-4 px-7 border-b border-neutral-400 text-xs   items-center">Name
    <span class="font-semibold text-black">{{ userData?.first_name }} {{ userData?.last_name }}</span>
  </div>

  <!-- Grid Row for Address -->
  <div class="grid grid-cols-2 gap-4 py-4 px-7 border-b border-neutral-400 text-xs items-center">Address
    <span class="font-semibold text-black">{{ userData?.address }}</span>
  </div>

  <!-- Grid Row for Contact Number -->
  <div class="grid grid-cols-2 gap-4 px-7 py-4 border-b border-neutral-400 text-xs items-center">Contact Number
    <span class="font-semibold text-black">{{ userData?.contact_number }}</span>
  </div>
</div>



<div class="w-full border font-normal bg-gray-200 text-gray-600 border-neutral-400 rounded mt-4">
  <!-- Profile and Other Data Section -->
  <div class="px-7 py-4 border-b border-neutral-400 text-gray-700 font-semibold flex justify-between items-center">
    Profile and Other Data
  </div>
  
  

  <!-- Grid Row for Name -->
  <div class="grid grid-cols-2 gap-4 py-4 px-7 border-b border-neutral-400 text-xs items-center">Profile Image
    <img v-if="userData" :src="userData.profile_image" alt="Profile Image" class="w-12 h-12 object-cover rounded-full border border-gray-400 shadow-md" />
  </div>

  <!-- Grid Row for Address -->
  <div class="grid grid-cols-2 gap-4 py-4 px-7 border-b border-neutral-400 text-xs items-center">Birthdate
    <span class="font-semibold text-black">{{ userData?.birthdate }}</span>
  </div>

  <!-- Grid Row for Contact Number -->
  <div class="grid grid-cols-2 gap-4 px-7 py-4 border-b border-neutral-400 text-xs items-center">School Id Number
    <span class="font-semibold text-black">{{ userData?.school_id_number }}</span>
  </div>
  <div class="grid grid-cols-2 gap-4 px-7 py-4 border-b border-neutral-400 text-xs items-center">Grade Level
    <span class="font-semibold text-black">{{ userData?.grade_year }}</span>
  </div>
</div>

<div class="w-full border font-normal bg-gray-200  border-neutral-400 rounded mt-4">
  
  <div class="px-7 py-4 border-b border-neutral-400 font-semibold text-gray-700 flex justify-between items-center">
    Account
  </div>
 
  <div class="flex-row flex py-4 px-7 border-b border-neutral-400 justify-between">
    <div class="flex-col flex  text-sm font-semibold ">Edit Account
    <span class="font-normal text-xs text-gray-600">This feature allows you to update your personal and account information for accuracy and convenience.</span>
  </div>
    <button @click="toggleEditMode" class="px-14 text-xs rounded-md font-normal bg-blue-500 text-white py-2">Edit</button>
  </div>
  <div class="flex-row flex py-4 px-7 border-b border-neutral-400 justify-between">
    <div class="flex-col flex  text-sm font-semibold ">Delete Account
    <span class="font-normal text-xs text-gray-600">Keep in mind that upon deleting your account all of your account information will be deleted without the possibility of restoration.</span>
  </div>
    <button @click="openDeleteModal" class="px-5 text-xs rounded-md font-normal bg-red-500 text-white py-2">Delete Account</button>
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

         <!-- Profile Image Upload -->
      <div class="flex flex-row space-x-3  items-center mb-4">
        <img v-if="editData.profile_image" :src="editData.profile_image" alt="Profile Image Preview" class="w-32 h-32 object-cover rounded-full border border-gray-400 shadow-md mb-3" />
        <input type="file" @change="onImageChange" accept="image/*" class="text-sm text-gray-600" />
      </div>
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
        <button @click="toggleEditMode" type="button" class="bg-gray-400 hover:bg-gray-500  text-white px-6 py-2 rounded-md text-sm">Cancel</button>
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

// Image change handler
const onImageChange = (event) => {
  const file = event.target.files[0]
  if (file) {
    const reader = new FileReader()
    reader.onload = () => {
      editData.value.profile_image = reader.result // Set the preview image
    }
    reader.readAsDataURL(file) // Convert to base64 for preview
  }
}


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
