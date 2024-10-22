<template>
  <div class="min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-1/4 bg-gray-200 p-4">
      <h2 class="text-lg font-bold">Navigation</h2>
      <ul>
        <li>
          <router-link to="/student/home" class="block py-2">Home</router-link>
        </li>
        <li>
          <router-link to="/student/courses" class="block py-2">Courses</router-link>
        </li>
        <li>
          <router-link to="/student/profile" class="block py-2">Profile</router-link>
        </li>
        <li>
          <router-link to="/student/settings" class="block py-2">Settings</router-link>
        </li>
      </ul>
      <button @click="handleLogout" class="mt-4 w-full bg-red-500 text-white py-2 rounded">
        Logout
      </button>
    </aside>

    <!-- Main Content -->
    <main class="flex-grow p-4">
      <h1 class="text-3xl font-bold underline">Student Home Page</h1>
      <!-- Add additional student information here -->
      <div class="mt-4">
        <p>Welcome back, Student!</p>
        <p>Here you can find your courses, track your progress, and manage your profile.</p>
      </div>
    </main>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router';

// Logic for handling logout
const router = useRouter();

const handleLogout = () => {
  // Clear token and user type from local storage
  localStorage.removeItem('app_auth_token');
  localStorage.removeItem('user_type');
  // Redirect to the login page
  router.push('/login');
};
</script>

<style scoped>
/* Styles for the sidebar and main content */
.container {
  max-width: 1200px;
  margin: 0 auto;
}

aside {
  border-right: 1px solid #ccc;
}

aside ul {
  list-style-type: none;
  padding: 0;
}

aside li {
  margin-bottom: 10px;
}
</style>
