<template>
  <NavBar />
  <div class=" bg-white">
    <div class="flex min-h-[calc(100vh-5rem)]  flex-col justify-center items-center px-6 pb-24 lg:px-8">
      <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <h2 class="mt-10 text-center text-2xl font-bold text-gray-900">
          Sign in to your account
        </h2>
      </div>

      <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6" @submit.prevent="handleLogin">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-900">
              Email address
            </label>
            <div class="mt-2">
              <input
                id="email"
                v-model="email"
                type="email"
                autocomplete="email"
                placeholder="Email"
                required
                class="block w-full rounded-lg px-3 py-2 text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
              />
            </div>
          </div>

          <div>
            <div class="flex items-center justify-between">
              <label for="password" class="block text-sm font-medium text-gray-900">
                Password
              </label>
              <div class="text-sm">
                <a href="#" class="font-semibold text-blue-600 hover:text-blue-500">
                  Forgot password?
                </a>
              </div>
            </div>
            <div class="mt-2">
              <input
                id="password"
                v-model="password"
                type="password"
                autocomplete="current-password"
                placeholder="Password"
                required
                class="block w-full rounded-lg px-3 py-2 text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
              />
            </div>
          </div>

          <!-- Error Message with transition -->
          <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="transform -translate-y-1 opacity-0"
            enter-to-class="transform translate-y-0 opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="transform translate-y-0 opacity-100"
            leave-to-class="transform -translate-y-1 opacity-0"
          >
            <div v-if="errorMessage" class="text-red-500 text-sm text-center bg-red-50 p-2 rounded-lg">
              {{ errorMessage }}
            </div>
          </Transition>

          <div class="space-y-4">
            <button
              type="submit"
              class="flex w-full justify-center rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus:ring-2 focus:ring-offset-2 focus:ring-blue-600"
            >
              Sign in
            </button>

            <p class="text-center text-sm text-gray-500">
              Not yet registered?
              <a href="/register" class="font-semibold text-blue-600 hover:text-blue-500">
                Sign up
              </a>
            </p>
          </div>
        </form>
      </div>
    </div>
  </div>
  <FooterSection />
</template>

<script setup>
import FooterSection from '@/sections/FooterSection.vue'
import NavBar from '@/sections/NavBar.vue'
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axiosInstance from '@/axiosInstance'

// State for form inputs and error handling
const email = ref('')
const password = ref('')
const errorMessage = ref('')

// Vue Router instance for navigation
const router = useRouter()

// Add timer function
const showErrorWithTimer = (message) => {
  errorMessage.value = message
  setTimeout(() => {
    errorMessage.value = ''
  }, 3000) // Error will disappear after 3 seconds
}

// Login handler function
const handleLogin = async () => {
  try {
    const response = await axiosInstance.post('api/login', {
      email: email.value,
      password: password.value,
    })

    const { user_email, user_full_name, user_type, user_data, token } =
      response.data

    // Store token in localStorage
    localStorage.setItem('app_auth_token', token)
    localStorage.setItem('user_type', user_type)
    localStorage.setItem('user_email', user_email)
    localStorage.setItem('user_full_name', user_full_name)
    localStorage.setItem('user_data', JSON.stringify(user_data))

    if (user_type === 'Tutor') {
      // Check approval status for tutors
      if (user_data.approval_status === 'Pending') {
        router.push('/tutor/pending-approval')
      } else {
        router.push('/tutor/profile')
      }
    }
    if (user_type === 'Student') {
      router.push('/student/home')
    }
  } catch (error) {
    // Use the timer function instead of direct assignment
    showErrorWithTimer(
      error.response?.data?.message || 'An error occurred. Please try again.'
    )
  }
}
</script>

<style scoped>
/* Basic styling */
.login-container {
  max-width: 400px;
  margin: 100px auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  text-align: center;
}

.input-group {
  margin-bottom: 15px;
  text-align: left;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: 500;
}

input {
  width: 100%;
  padding: 8px;
  margin-bottom: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  width: 100%;
  padding: 10px;

  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.error {
  color: red;
  margin-top: 10px;
}
</style>
