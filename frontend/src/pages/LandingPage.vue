<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Navbar -->
   <NavBar />

    <!-- Main Content -->
    <main class="flex  max-w-7xl mx-auto  sm:px-6 lg:px-8  h-screen relative">

  <!-- Content -->
  <div class="flex flex-row space-x-12">
    <div class=" w-[680px] h-[500px] mt-[80px]">
    <h2 class="text-[50px] flex font-bold text-gray-800 mb-4">Empower Your Learning Journey with TUDLO's Peer Tutoring</h2>
    <p class="text-gray-600 mb-8">Find the support you need from fellow students, and excel in your studies with personalized tutoring.</p>
    <button class="px-4 py-2 rounded-md text-white bg-indigo-500 hover:bg-indigo-400">Get Started</button>
  </div>
  <div class="w-[500px] h-[500px]]">
    <img src="/image/hero.png" alt="Hero image">

  </div>
  </div>
</main>
    <div class="flex justify-center">
    <h1 class="text-[50px] font-bold">About</h1>
    <div>
      
    </div>
  </div>
  <FooterSection />
  </div>
</template>

<script setup>
import NavBar from '../sections/NavBar.vue';
import FooterSection from '../sections/FooterSection.vue';
import { useRouter } from 'vue-router';
import { ref } from 'vue';

// Initialize Router
const router = useRouter();

// Authentication State (replace with actual logic if needed)
const isAuthenticated = ref(!!localStorage.getItem('app_auth_token')); // Boolean value from token
const userType = ref(localStorage.getItem('user_type')); // Get user type: 'tutor' or 'student'

// Navigation Functions
function goToLogin() {
  router.push('/login');
}

function goToRegister() {
  router.push('/register');
}

function goToUserPage() {
  if (userType.value === 'Tutor') {
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
