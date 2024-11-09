<template>
  <div class="mb-6">
    <h3 class="font-medium mb-2">
      Tutor Rate:
      <button @click="toggleEditMode" class="ml-2 text-blue-600">{{ isEditing ? 'Cancel' : 'Edit' }}</button>
    </h3>
    <div v-if="!isEditing">
      <p class="text-blue-500">P{{ userData.tutor_rate }}/Session</p>
    </div>
    <div v-else>
      <input
        type="number"
        v-model.number="tutorRate"
        class="border rounded px-2 py-1 text-black"
        min="0"
      />
      <button @click="saveTutorRate" class="mt-2 text-blue-600">Save</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axiosInstance from '@/axiosInstance'

// Retrieve user data from local storage
const getUserData = localStorage.getItem('user_data');
const parsedUserData = getUserData ? JSON.parse(getUserData) : {};
const userData = ref(parsedUserData);

// Local state for tutor rate, initialized with user data
const tutorRate = ref(userData.value.tutor_rate || 0);
const isEditing = ref(false); // Ref to track editing state

// Toggle edit mode
const toggleEditMode = () => {
  if (isEditing.value) {
    tutorRate.value = userData.value.tutor_rate; // Reset to original value when cancelling
  } else {
    tutorRate.value = userData.value.tutor_rate; // Set to current tutor rate when entering edit mode
  }
  isEditing.value = !isEditing.value; // Toggle editing state
};

// Function to save the tutor rate to the backend
const saveTutorRate = async () => {
  try {
    // Prepare the data to be sent in the PUT request
    const data = {
      tutor_rate: Math.floor(tutorRate.value) // Ensure value is an integer
    };

    // Make the PUT request to your API endpoint
    await axiosInstance.post('/api/edit-details', data); // Replace with your actual API endpoint

    // Update the user data in local storage after a successful request
    userData.value.tutor_rate = data.tutor_rate; // Update with the new rate
    localStorage.setItem('user_data', JSON.stringify(userData.value)); // Save updated data to local storage
    isEditing.value = false; // Exit edit mode after saving
  } catch (error) {
    console.error('Error saving tutor rate:', error); // Handle any errors
  }
};
</script>
