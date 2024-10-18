<template>
  <div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">Register as a Tutor</h1>
    <form @submit.prevent="registerTutor">
      <div class="mb-4">
        <label for="user_type" class="block text-sm font-medium">User Type</label>
        <select v-model="form.user_type" id="user_type" required class="mt-1 p-2 border rounded">
          <option value="1">Tutor</option>
        </select>
      </div>

      <div class="mb-4">
        <label for="email" class="block text-sm font-medium">Email</label>
        <input
          type="email"
          id="email"
          v-model="form.email"
          required
          class="mt-1 p-2 border rounded w-full"
        />
      </div>

      <div class="mb-4">
        <label for="password" class="block text-sm font-medium">Password</label>
        <input
          type="password"
          id="password"
          v-model="form.password"
          required
          class="mt-1 p-2 border rounded w-full"
          minlength="8"
        />
      </div>

      <div class="mb-4">
        <label for="password_confirmation" class="block text-sm font-medium">Confirm Password</label>
        <input
          type="password"
          id="password_confirmation"
          v-model="form.password_confirmation"
          required
          class="mt-1 p-2 border rounded w-full"
        />
      </div>

      <div class="mb-4">
        <label for="first_name" class="block text-sm font-medium">First Name</label>
        <input
          type="text"
          id="first_name"
          v-model="form.first_name"
          required
          class="mt-1 p-2 border rounded w-full"
        />
      </div>

      <div class="mb-4">
        <label for="last_name" class="block text-sm font-medium">Last Name</label>
        <input
          type="text"
          id="last_name"
          v-model="form.last_name"
          required
          class="mt-1 p-2 border rounded w-full"
        />
      </div>

      <div class="mb-4">
        <label for="address" class="block text-sm font-medium">Address</label>
        <input
          type="text"
          id="address"
          v-model="form.address"
          required
          class="mt-1 p-2 border rounded w-full"
        />
      </div>

      <div class="mb-4">
        <label for="birthdate" class="block text-sm font-medium">Birthdate</label>
        <input
          type="date"
          id="birthdate"
          v-model="form.birthdate"
          required
          class="mt-1 p-2 border rounded w-full"
        />
      </div>

      <div class="mb-4">
        <label for="gender" class="block text-sm font-medium">Gender</label>
        <select v-model="form.gender" id="gender" class="mt-1 p-2 border rounded">
          <option value="male">Male</option>
          <option value="female">Female</option>
          <option value="other">Other</option>
        </select>
      </div>

      <div class="mb-4">
        <label for="contact_number" class="block text-sm font-medium">Contact Number</label>
        <input
          type="text"
          id="contact_number"
          v-model="form.contact_number"
          required
          class="mt-1 p-2 border rounded w-full"
        />
      </div>

      <button type="submit" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded">
        Register
      </button>

      <div v-if="errorMessage" class="mt-4 text-red-500">{{ errorMessage }}</div>
      <div v-if="successMessage" class="mt-4 text-green-500">{{ successMessage }}</div>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const form = ref({
  user_type: '1', // Set user_type to '1' for tutor
  email: '',
  password: '',
  password_confirmation: '',
  first_name: '',
  last_name: '',
  address: '',
  birthdate: '',
  gender: '',
  contact_number: '',
});

const errorMessage = ref('');
const successMessage = ref('');

const registerTutor = async () => {
  try {
    errorMessage.value = '';
    successMessage.value = '';

    const response = await axios.post('/api/register', form.value); // Adjust the URL based on your API setup

    successMessage.value = response.data.message; // Display success message
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'An error occurred during registration.';
  }
};
</script>

<style scoped>
.container {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
}
</style>
