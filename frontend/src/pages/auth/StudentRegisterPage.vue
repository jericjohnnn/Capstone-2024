<template>
  <div class="register-container">
    <h2>Sign-up as Student</h2>

    <form @submit.prevent="handleSubmit">
      <div class="input-group">
        <input type="email" v-model="form.email" placeholder="Email" required />
        <input
          type="password"
          v-model="form.password"
          placeholder="Password"
          required
        />
        <input
          type="password"
          v-model="form.confirmPassword"
          placeholder="Confirm password"
          required
        />
      </div>

      <div class="input-group">
        <input
          type="text"
          v-model="form.firstName"
          placeholder="First name"
          required
        />
        <input
          type="text"
          v-model="form.lastName"
          placeholder="Last name"
          required
        />
      </div>

      <div class="input-group">
        <input
          type="text"
          v-model="form.address"
          placeholder="Address"
          required
        />
        <input
          type="date"
          v-model="form.birthdate"
          placeholder="Birthdate"
          required
        />
        <input
          type="text"
          v-model="form.contactNo"
          placeholder="Contact no."
          required
        />
        <select v-model="form.gradeYear" required>
          <option value="" disabled>Select Grade Year</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
        </select>
        <input
          type="text"
          v-model="form.schoolIdNo"
          placeholder="School ID Number"
          required
        />
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
import { reactive } from 'vue'
import axiosInstance from '@/axiosInstance'
import router from '@/router'

const form = reactive({
  email: '',
  password: '',
  confirmPassword: '',
  firstName: '',
  lastName: '',
  address: '',
  birthdate: '',
  contactNo: '',
  schoolIdNo: '',
  gradeYear: '',
  agreeToTerms: false,
})

const handleSubmit = async () => {
  if (form.password !== form.confirmPassword) {
    alert('Passwords do not match!')
    return
  }

  const payload = {
    user_type_id: 1,
    email: form.email,
    password: form.password,
    password_confirmation: form.confirmPassword,
    first_name: form.firstName,
    last_name: form.lastName,
    address: form.address,
    birthdate: form.birthdate,
    school_id_number: form.schoolIdNo,
    grade_year: form.gradeYear,
    contact_number: form.contactNo,
  }

  try {
    const response = await axiosInstance.post('api/register', payload)
    const { message, user_email, user_full_name, user_type, user_data, token } =
      response.data
    alert(message)
    localStorage.setItem('app_auth_token', token)
    localStorage.setItem('user_type', user_type)
    localStorage.setItem('user_email', user_email)
    localStorage.setItem('user_full_name', user_full_name)
    localStorage.setItem('user_data', JSON.stringify(user_data));
    router.push('/student/home')
  } catch (error) {
    alert(
      'Registration failed: ' +
        (error.response?.data?.message || error.message),
    )
  }
}
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

.input-group select {
  flex: 1;
  min-width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 1rem;
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

.input-group input {
  flex: 1;
  min-width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 1rem;
}

input[type='date'] {
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
