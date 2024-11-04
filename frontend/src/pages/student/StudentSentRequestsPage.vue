<template>
  <main class="">
    <SideBar>
      <main class="container p-5 mx-auto">

      </main>
    </SideBar>

    <HelpButton />
  </main>
</template>

<script setup>
import SideBar from '@/components/SideBar.vue'
import HelpButton from '@/components/HelpButton.vue'
// import { ref, reactive, onMounted, watch } from 'vue'
// import axiosInstance from '@/axiosInstance'


// const route = useRoute()

// const getUserData = localStorage.getItem('user_data')
// const userData = getUserData ? JSON.parse(getUserData) : null
// const studentContactNumber = userData ? userData.contact_number : null

// const notificationsPlaceholder = [
//   {
//     id: 1,
//     content: "Your tutoring with Janela bano has completed please rate tutor janela to book her next time."
//   },
//   {
//      id: 2,
//     content: "Janela bano accepted your tutor request. tutoring is now ongoing. He/She will be contact you with your provided number"
//   },
//   {
//      id: 3,
//     content: "You booked Janela bano, request is now pending. you can check on pending requests in the tutor requests tab"
//   },
// ]

</script>
