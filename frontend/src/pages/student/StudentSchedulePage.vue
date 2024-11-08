<template>
  <main class="bg-blue-200">
    <SideBar>
      <div class="container mx-auto ">
        <div class="">
          <div class="flex justify-center font-bold text-2xl py-5">
            Schedules
          </div>
          <div class="flex justify-center bg-white rounded-xl h-[500px]">
           <div class=" flex flex-col pt-7 space-y-4">
            <div class="border-2 border-indigo-500 bg-indigo-200 w-[1000px] h-[100px]  rounded-lg">
              hi
            </div>
            <div class="border-2 border-indigo-500 bg-indigo-200 w-[1000px] h-[100px]  rounded-lg">
              hi
            </div>
          </div>
          </div>
        </div>
      </div>
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


</script>
