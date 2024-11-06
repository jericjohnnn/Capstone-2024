<template>
  <div>
    <h3 class="font-semibold">BIO</h3>
    <div v-if="!isEditing">
      <p class="text-sm text-gray-700">
        {{ userData.biography || 'No biography provided' }}
      </p>
      <button
        @click="isEditing = true"
        class="text-blue-500 text-sm hover:underline"
      >
        Edit
      </button>
    </div>

    <div v-else>
      <textarea
        v-model="userData.biography"
        class="w-full p-2 border border-gray-300 rounded-sm text-sm"
        placeholder="Write your biography here..."
      ></textarea>
      <div class="mt-2 flex gap-2">
        <button
          @click="cancelEdit"
          class="px-4 py-1 text-sm text-gray-600 hover:text-gray-800"
        >
          Cancel
        </button>
        <button
          @click="saveBiography"
          class="px-4 py-1 text-sm text-green-600 hover:text-green-800"
        >
          Save
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axiosInstance from '@/axiosInstance'

// Fetch user data from local storage
const getUserData = localStorage.getItem('user_data')
const parsedUserData = getUserData ? JSON.parse(getUserData) : {}
const userData = ref(parsedUserData)

const isEditing = ref(false)

const saveBiography = async () => {
  try {
    await axiosInstance.post('/api/edit-details', {
      biography: userData.value.biography,
    })
    // Save the updated data locally after successful save
    localStorage.setItem('user_data', JSON.stringify(userData.value))
    isEditing.value = false
  } catch (error) {
    console.error('Failed to update biography:', error)
    alert('Failed to update biography')
  }
}

const cancelEdit = () => {
  // Restore the original biography if editing is canceled
  userData.value.biography = parsedUserData.biography
  isEditing.value = false
}
</script>
