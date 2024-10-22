<template>
  <div class="w-72 h-screen bg-slate-400">
    <div>
      <!-- Main title "Tudlo" -->
      <div class="flex justify-center p-4 font-serif">
        <h1 class="text-xl font-bold">Tudlo</h1>
      </div>
      
      <div class="flex justify-center flex-col items-center">
        <ul>
        <li class="text-xs text-gray-700">
          <router-link to="/admin/tutorApplication">Tutor Application</router-link>
        </li>
        <li class="text-xs text-gray-700">
          <router-link to="/admin/activeTutors">Active Tutors</router-link>
        </li>
        <li class="text-xs text-gray-700">
          <router-link to="/admin/activeStudents">Active Students</router-link>
        </li>
        <li class="text-xs text-gray-700">
          <router-link to="/admin/reports">User Reports</router-link>
        </li>
      </ul>
      </div>

    </div>
  </div>
</template>

<script setup>
// Add logic here
</script>

<style scoped>
/* Add styles here */
</style>
