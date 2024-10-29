<template>
  <div class="font-sans">
    <div class="w-[200px] h-screen bg-slate-400">
      <div>
        <div class="flex justify-center py-8">
          <h1 class="text-4xl font-bold">Tudlo</h1>
        </div>
        <div class="flex justify-center flex-col items-center">
          <ul>
            <li class="text-lg text-gray-700">
              <router-link 
                to="/admin/tutorApplication" 
                active-class="font-bold"
                exact-active-class="font-bold"
              >
                Tutor Application
              </router-link>
            </li>
            <li class="text-lg text-gray-700">
              <router-link 
                to="/admin/activeTutors" 
                active-class="font-bold"
                exact-active-class="font-bold"
              >
                Active Tutors
              </router-link>
            </li>
            <li class="text-lg text-gray-700">
              <router-link 
                to="/admin/activeStudents" 
                active-class="font-bold"
                exact-active-class="font-bold"
              >
                Active Students
              </router-link>
            </li>
            <li class="text-lg text-gray-700">
              <router-link 
                to="/admin/reports" 
                active-class="font-bold"
                exact-active-class="font-bold"
              >
                User Reports
              </router-link>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
// Add logic here if needed
</script>

<style scoped>
/* Add styles here */
.font-bold {
  font-weight: bold;
}
</style>
