<template>
  <main class="bg-blue-200">
    <SideBar>
      <div class="container mx-auto">
        <div class="flex justify-center font-bold text-2xl py-5">
          Notifications
        </div>
        <div class="flex justify-center bg-white rounded-xl h-[500px] overflow-y-scroll">
          <div class="flex flex-col pt-7">
            <!-- Loop through the notifications and display them -->
            <div
              v-for="notification in notifications"
              :key="notification.id"
              class="border-2 border-indigo-500 bg-indigo-200 w-full md:w-[800px] lg:w-[1000px] h-[50px] rounded-lg p-4 mb-4 shadow-lg flex"
            >
              <p class="flex items-center">{{ notification.message }}</p>
            </div>
          </div>
        </div>
      </div>
    </SideBar>

    <HelpButton />
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import SideBar from '@/components/SideBar.vue';
import HelpButton from '@/components/HelpButton.vue';
import axiosInstance from '@/axiosInstance';

// Store notifications in a ref
const notifications = ref([]);

// Fetch notifications from the API on component mount
onMounted(async () => {
  try {
    const response = await axiosInstance.get('/api/user-notifications');
    console.log(response.data); // Log the full response

    // Sort notifications in descending order by created_at (latest first)
    notifications.value = response.data.notifications.sort((a, b) => {
      return new Date(b.created_at) - new Date(a.created_at);
    });
  } catch (error) {
    console.error('Error fetching notifications:', error);
  }
});
</script>
