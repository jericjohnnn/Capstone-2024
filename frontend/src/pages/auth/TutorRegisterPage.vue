<template>
  <div class="register-container">
    <h2>Sign-up as TUTOR</h2>

    <form @submit.prevent="handleSubmit">
      <div class="input-group">
        <input type="email" v-model="form.email" placeholder="Email" required />
        <input type="password" v-model="form.password" placeholder="Password" required />
        <input
          type="password"
          v-model="form.confirmPassword"
          placeholder="Confirm password"
          required
        />
      </div>

      <div class="input-group">
        <input type="text" v-model="form.firstName" placeholder="First name" required />
        <input type="text" v-model="form.lastName" placeholder="Last name" required />
      </div>

      <div class="input-group">
        <input type="text" v-model="form.address" placeholder="Address" required />
        <input type="date" v-model="form.birthdate" placeholder="Birthdate" required />
        <select v-model="form.gender" required>
          <option value="" disabled>Select Gender</option>
          <option value="male">Male</option>
          <option value="female">Female</option>
          <option value="other">Other</option>
        </select>
      </div>

      <div class="input-group">
        <input type="text" v-model="form.contactNo" placeholder="Contact no." required />
      </div>

      <!-- New Fields -->
      <div class="input-group">
        <input
          type="number"
          v-model="form.tutorRate"
          placeholder="Tutor Rate (int)"
          required
        />
        <input
          type="text"
          v-model="form.schoolIdNumber"
          placeholder="School ID Number"
          required
        />
      </div>

      <div class="input-group">
        <select v-model="form.course" required>
          <option value="" disabled>Select Course</option>
          <option value="BSED">BSED</option>
          <option value="BEED">BEED</option>
          <option value="BSIT">BSIT</option>
          <option value="BSHM">BSHM</option>
          <option value="BSENTREP">BSENTREP</option>
        </select>

        <select v-model="form.year" required>
          <option value="" disabled>Select Year</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </div>

      <div class="terms-group">
        <input type="checkbox" v-model="form.agreeToTerms" required />
        <label>I agree to <a href="#">Terms & Conditions</a></label>
      </div>

      <button type="submit" :disabled="!form.agreeToTerms">Sign-up</button>
    </form>
  </div>
</template>

<script setup>
import { reactive } from 'vue';
import axiosInstance from '@/axiosInstance'
import router from '@/router';

const form = reactive({
  email: '',
  password: '',
  confirmPassword: '',
  firstName: '',
  lastName: '',
  address: '',
  birthdate: '',
  gender: '',
  contactNo: '',
  tutorRate: '', // New field
  schoolIdNumber: '', // New field
  course: '', // New field
  year: '', // New field
  agreeToTerms: false,
});

const handleSubmit = async () => {
  if (form.password !== form.confirmPassword) {
    alert("Passwords do not match!");
    return;
  }

  const payload = {
    user_type_id: 2,
    email: form.email,
    password: form.password,
    password_confirmation: form.confirmPassword,
    first_name: form.firstName,
    last_name: form.lastName,
    address: form.address,
    birthdate: form.birthdate,
    gender: form.gender,
    contact_number: form.contactNo,
    tutor_rate: form.tutorRate, // New field
    school_id_number: form.schoolIdNumber, // New field
    course: form.course, // New field
    year: form.year, // New field
  };

  try {
    const response = await axiosInstance.post('api/register', payload);
    const { message, user_type, token } = response.data
    alert(message);
    localStorage.setItem('app_auth_token', token)
    localStorage.setItem('user_type', user_type)
    router.push('/tutor/profile')

  } catch (error) {
    alert("Registration failed: " + (error.response?.data?.message || error.message));
  }
};
</script>

<style scoped>
.register-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
  background-color: #e0f0ff;
  text-align: center;
  padding: 20px;
  border: 1px solid #4b8ff7;
  border-radius: 8px;
}

form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  width: 100%;
  max-width: 400px;
}

.input-group {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
}

.input-group input,
.input-group select {
  flex: 1;
  min-width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 1rem;
}

input[type="date"] {
  color: #555;
}

.terms-group {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

button {
  background-color: #4b8ff7;
  color: white;
  padding: 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

button:disabled {
  background-color: #c0c0c0;
  cursor: not-allowed;
}

button:hover:enabled {
  background-color: #3a7ddb;
}
</style>
