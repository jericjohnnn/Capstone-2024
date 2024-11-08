<template>
<main class="">
    <SideBar>
      <main class="container p-5 mx-auto">
        <SchedulesCalendar></SchedulesCalendar>
      </main>
    </SideBar>

    <HelpButton />
  </main>
</template>

<script setup>
import SchedulesCalendar from '@/components/TutorSchedule/SchedulesCalendar.vue';
import SideBar from '@/components/SideBar.vue'
import HelpButton from '@/components/HelpButton.vue'
// import { ref, reactive, onMounted, watch } from 'vue'
// import axiosInstance from '@/axiosInstance'


// const route = useRoute()

// const getUserData = localStorage.getItem('user_data')
// const userData = getUserData ? JSON.parse(getUserData) : null
// const studentContactNumber = userData ? userData.contact_number : null



</script>
