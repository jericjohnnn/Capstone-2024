<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-md">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex-shrink-0 flex items-center">
            <h1 class="text-2xl font-bold text-gray-800">MyApp</h1>
          </div>

          <div class="flex items-center space-x-4">
            <!-- Dynamic Navbar Links -->
            <template v-if="!isAuthenticated">
              <button
                @click="goToLogin"
                class="text-gray-800 hover:text-blue-500"
              >
                Login
              </button>
              <button
                @click="goToRegister"
                class="text-gray-800 hover:text-green-500"
              >
                Register
              </button>
            </template>

            <template v-else>
              <button
                @click="goToUserPage"
                class="text-gray-800 hover:text-blue-500"
              >
                {{ userType === 'tutor' ? 'Go to Profile' : 'Go to Home' }}
              </button>
            </template>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="flex items-center justify-center h-screen">
      <div class="text-center">
        <h2 class="text-4xl font-bold text-gray-800 mb-4">Welcome to MyApp!</h2>
        <p class="text-gray-600 mb-8">Explore, learn, and grow with us.</p>
      </div>
    </main>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { ref } from 'vue';

// Initialize Router
const router = useRouter();

// Authentication State (replace with actual logic if needed)
const isAuthenticated = ref(!!localStorage.getItem('authToken')); // Boolean value from token
const userType = ref(localStorage.getItem('user_type')); // Get user type: 'tutor' or 'student'

// Navigation Functions
function goToLogin() {
  router.push('/login');
}

function goToRegister() {
  router.push('/register');
}

function goToUserPage() {
  if (userType.value === 'tutor') {
    router.push('/tutor/profile'); // Navigate to tutor profile
  } else {
    router.push('/student/home'); // Navigate to student home
  }
}
</script>

<style scoped>
/* Navbar styling */
nav {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 10;
}

/* Center content vertically and horizontally */
main {
  margin-top: 64px; /* Adjust based on navbar height */
}
</style>
