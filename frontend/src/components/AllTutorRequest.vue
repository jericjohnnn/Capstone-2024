<template>
  <div class=" bg-red-300">
    
    <div v-if="bookings.length > 0">
      <div
        v-for="booking in bookings"
        :key="booking.id"
        class="border-2 border-indigo-500 bg-indigo-200 w-[1000px] my-4 rounded-lg p-4"
      >
        <div class="flex items-start space-x-6">
          <!-- Profile Image -->
          <div>
            <img :src="booking.profile_image" alt="Profile Image" class="w-16 h-16 rounded-full" />
          </div>

          <!-- Tutor Information -->
          <div class="">
            <p><strong>Tutor Name:</strong> {{ booking.tutor_name }}</p>
           
            <button class="text-white px-2 rounded-md bg-blue-500 mt-2">View Profile</button>
          </div>

          <!-- Subjects Information -->
          <div class="">
            <p><strong>Requested Subjects:</strong></p>
            <p>
              <span v-for="(subject, index) in booking.subjects" :key="index">
                {{ subject }}<span v-if="index < booking.subjects.length - 1">, </span>
              </span>
            </p>
          </div>

          <!-- Booking Status -->
          <div class="flex flex-row space-x-2">
            <button class="px-2 bg-blue-500 rounded-md text-white">Review Request</button>
            <p><strong>Status:</strong> {{ booking.booking_status }}</p>
          </div>
        </div>
      </div>
    </div>
    <p v-else>No bookings available.</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axiosInstance from '@/axiosInstance';

const bookings = ref([]); // To store fetched bookings

// Fetch bookings data when the component is mounted
onMounted(() => {
  axiosInstance.get('/api/bookings/all-tutor-request-bookings')
    .then(response => {
      bookings.value = response.data.bookings; // Assign the bookings data
    })
    .catch(error => {
      console.error("Error fetching bookings:", error);
    });
});
</script>
