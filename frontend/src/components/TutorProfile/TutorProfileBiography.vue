<template>
  <div>
    <h3 class="font-semibold">BIO</h3>
    <div v-if="!isEditing">
      <p class="text-sm text-gray-700">
        {{ userData.biography || 'No biography provided' }}
      </p>
      <button
        @click="startEditing"
        class="text-blue-500 text-sm hover:underline"
      >
        Edit
      </button>
    </div>

    <div v-else>
      <textarea
        v-model="editedBiography"
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
import { getUserData } from '@/utils/user'

const userData = getUserData()
const isEditing = ref(false)
const editedBiography = ref(userData.value.biography || '')

const startEditing = () => {
  editedBiography.value = userData.value.biography || ''
  isEditing.value = true
}

const saveBiography = async () => {
  try {
    await axiosInstance.post('/api/edit-details', {
      biography: editedBiography.value,
    })
    userData.value.biography = editedBiography.value
    localStorage.setItem('user_data', JSON.stringify(userData.value))
    isEditing.value = false
  } catch (error) {
    console.error('Failed to update biography:', error)
    alert('Failed to update biography')
  }
}

const cancelEdit = () => {
  isEditing.value = false
}
</script>
