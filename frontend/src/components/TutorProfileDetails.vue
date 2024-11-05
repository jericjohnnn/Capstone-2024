<template>
  <div>
    <h3 class="mt-4 font-semibold">Personal Details:</h3>
    <button @click="toggleEditMode" class="ml-2 text-blue-600">
      {{ isEditing ? 'Cancel' : 'Edit' }}
    </button>
    <ul class="mt-2 space-y-1 text-sm text-gray-700">
      <li v-if="!isEditing">{{ formatDate(userData.birthdate) }}</li>
      <li v-else>
        <input
          type="date"
          v-model="birthdate"
          class="border rounded px-2 py-1"
        />
      </li>
      <li v-if="!isEditing">{{ userData.address }}</li>
      <li v-else>
        <input
          type="text"
          v-model="address"
          class="border rounded px-2 py-1"
        />
      </li>
      <li v-if="!isEditing">{{ userData.contact_number }}</li>
      <li v-else>
        <input
          type="text"
          v-model="contactNumber"
          class="border rounded px-2 py-1"
        />
      </li>
    </ul>
    <div v-if="isEditing">
      <button @click="saveDetails" class="mt-2 text-blue-600">Save</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios'; // Ensure axios is imported

// Retrieve user data from local storage
const getUserData = localStorage.getItem('user_data');
const parsedUserData = getUserData ? JSON.parse(getUserData) : {};
const userData = ref(parsedUserData);

// Local state for editable fields
const birthdate = ref(userData.value.birthdate);
const address = ref(userData.value.address);
const contactNumber = ref(userData.value.contact_number);
const isEditing = ref(false); // Ref to track editing state

// Format the date for display
const formatDate = (date) => {
  return new Intl.DateTimeFormat('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  }).format(new Date(date));
};

// Toggle edit mode
const toggleEditMode = () => {
  if (isEditing.value) {
    // Reset the input fields to the original user data if cancelled
    birthdate.value = userData.value.birthdate;
    address.value = userData.value.address;
    contactNumber.value = userData.value.contact_number;
  }
  isEditing.value = !isEditing.value; // Toggle editing state
};

// Function to save the personal details to the backend
const saveDetails = async () => {
  try {
    // Prepare the data to be sent in the PUT request
    const data = {
      birthdate: birthdate.value,
      address: address.value,
      contact_number: contactNumber.value,
    };

    // Make the PUT request to your API endpoint
    await axios.put('/your-api-endpoint', data); // Replace with your actual API endpoint

    // Update user data in local storage after a successful request
    userData.value.birthdate = data.birthdate; // Update with the new birthdate
    userData.value.address = data.address; // Update with the new address
    userData.value.contact_number = data.contact_number; // Update with the new contact number
    localStorage.setItem('user_data', JSON.stringify(userData.value)); // Save updated data to local storage

    isEditing.value = false; // Exit edit mode after saving
  } catch (error) {
    console.error('Error saving personal details:', error); // Handle any errors
  }
};
</script>
