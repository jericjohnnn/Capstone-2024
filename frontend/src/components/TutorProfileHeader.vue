<template>
  <div class="p-4 bg-white rounded-lg shadow-md">
    <!-- Non-Editable Profile View -->
    <div v-if="!isProfileEdit" class="flex items-center justify-between">
      <div class="flex items-center gap-4">
        <img 
          class="w-20 h-20 rounded-full object-cover bg-gray-200" 
          :src="userData.profile_image || defaultProfileImage" 
          alt="Profile Image" 
        />
        <div>
          <h2 class="text-lg font-semibold">{{ userData.first_name }} {{ userData.last_name }}</h2>
          <p>{{ userEmail }}</p>
        </div>
      </div>
      <div class="flex gap-4">
        <button 
          @click="isProfileEdit = true" 
          class="px-2 py-1 text-sm text-white bg-gray-600 rounded hover:bg-gray-700"
        >
          Edit
        </button>
        <router-link 
          class="px-4 py-2 text-sm text-white bg-blue-500 rounded hover:bg-blue-600" 
          :to="{ name: 'TutorSettings' }"
        >
          Profile settings
        </router-link>
      </div>
    </div>

    <!-- Editable Profile View -->
    <div v-if="isProfileEdit" class="flex items-start justify-between">
      <div class="flex gap-4">
        <!-- Profile Image Upload -->
        <div class="relative">
          <input 
            type="file" 
            ref="fileInput" 
            @change="handleFileUpload" 
            class="hidden" 
            accept="image/*"
          />
          <div 
            @click="openFilePicker"
            class="w-20 h-20 rounded-full cursor-pointer relative group"
          >
            <img
              class="w-full h-full rounded-full object-cover bg-gray-200"
              :src="selectedProfileImage"
              alt="Profile Image"
            />
            <div class="absolute inset-0 flex items-center justify-center rounded-full bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all">
              <span class="text-white text-3xl opacity-0 group-hover:opacity-100">+</span>
            </div>
          </div>
        </div>

        <!-- Edit Form -->
        <div class="flex flex-col gap-2 w-64">
          <div class="flex gap-2">
            <input
              v-model="userData.first_name"
              type="text"
              class="w-1/2 px-2 py-1 border border-gray-300 rounded text-sm"
              placeholder="First name"
            />
            <input
              v-model="userData.last_name"
              type="text"
              class="w-1/2 px-2 py-1 border border-gray-300 rounded text-sm"
              placeholder="Last name"
            />
          </div>
          <input
            v-model="userEmail"
            type="email"
            class="w-full px-2 py-1 border border-gray-300 rounded text-sm"
            placeholder="Email"
          />
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="flex gap-4">
        <button 
          @click="cancelEdit" 
          class="px-4 py-1 text-sm text-gray-600 hover:text-gray-800"
        >
          cancel
        </button>
        <button 
          @click="submitFile" 
          class="px-4 py-1 text-sm text-green-600 hover:text-green-800"
        >
          save
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const userEmail = ref(localStorage.getItem('user_email'))
const getUserData = localStorage.getItem('user_data')
const userData = ref(getUserData ? JSON.parse(getUserData) : {})

const isProfileEdit = ref(false)
const fileInput = ref(null)
const selectedFile = ref(null)

const defaultProfileImage = 'data:image/svg+xml;base64,' + btoa(
  `<svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24">
    <circle cx="12" cy="12" r="11" fill="white" stroke="#E5E7EB" stroke-width="2"/>
    <text x="12" y="12" text-anchor="middle" dy=".3em" font-size="16" fill="#9CA3AF">+</text>
  </svg>`
)

const selectedProfileImage = ref(userData.value.profile_image || defaultProfileImage)

const openFilePicker = () => {
  fileInput.value.click()
}

const handleFileUpload = event => {
  const file = event.target.files[0]
  if (file && file.type.startsWith('image/')) {
    selectedFile.value = file
    selectedProfileImage.value = URL.createObjectURL(file)
  }
}

const submitFile = async () => {
  try {
    const formData = new FormData()
    if (selectedFile.value) {
      formData.append('file', selectedFile.value)
    }
    formData.append('first_name', userData.value.first_name)
    formData.append('last_name', userData.value.last_name)
    formData.append('email', userEmail.value)

    //add const response = here
    await axios.post('/api/update-profile', formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    })

    localStorage.setItem('user_email', userEmail.value)
    localStorage.setItem('user_data', JSON.stringify(userData.value))

    isProfileEdit.value = false
  } catch (error) {
    console.error('Update failed:', error)
    alert('Failed to update profile')
  }
}

const cancelEdit = () => {
  const savedData = JSON.parse(localStorage.getItem('user_data') || '{}')
  userData.value = savedData
  userEmail.value = localStorage.getItem('user_email')
  selectedProfileImage.value = savedData.profile_image || defaultProfileImage
  selectedFile.value = null
  isProfileEdit.value = false
}
</script>