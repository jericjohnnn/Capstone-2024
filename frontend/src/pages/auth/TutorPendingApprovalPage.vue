<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="max-w-md w-full p-6 bg-white rounded-lg shadow-lg text-center">
      <div class="mb-8">
        <!-- You can add an icon here -->
        <svg 
          class="mx-auto h-16 w-16 text-yellow-400"
          fill="none" 
          stroke="currentColor" 
          viewBox="0 0 24 24"
        >
          <path 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
          />
        </svg>
      </div>

      <h2 class="text-2xl font-bold text-gray-900 mb-4">
        Registration Pending Approval
      </h2>
      
      <p class="text-gray-600 mb-8">
        Your registration is currently under review. Please wait for admin approval to access your account.
      </p>

      <div class="flex gap-4 justify-center">
        <button 
          @click="goHome" 
          class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors"
        >
          Go Home
        </button>
        
        <button 
          @click="logout" 
          class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors"
        >
          Logout
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

const goHome = () => {
  router.push('/')
}

const logout = () => {
  // Clear all localStorage items
  localStorage.removeItem('app_auth_token')
  localStorage.removeItem('user_type')
  localStorage.removeItem('user_email')
  localStorage.removeItem('user_full_name')
  localStorage.removeItem('user_data')
  
  // Redirect to login page
  router.push('/login')
}
</script>

<style scoped>
/* Add styles here */
</style>
