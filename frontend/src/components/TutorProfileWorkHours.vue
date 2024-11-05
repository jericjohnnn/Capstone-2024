<template>
  <div class="mb-6">
    <h3 class="font-medium mb-2">
      Hours available:
      <button @click="toggleEditMode" class="ml-2 text-blue-600">{{ isEditing ? 'Cancel' : 'Edit' }}</button>
    </h3>
    <div v-if="!isEditing">
      <p class="text-blue-600 font-medium">{{ formattedStartTime }} - {{ formattedEndTime }}</p>
    </div>
    <div v-else>
      <div class="flex items-center">
        <select v-model="startHour" class="border p-1 rounded">
          <option v-for="hour in hours" :key="hour" :value="hour">{{ hour }}</option>
        </select>
        <select v-model="startMinute" class="border p-1 rounded mx-2">
          <option value="0">00</option>
          <option value="30">30</option>
        </select>
        <select v-model="startAmPm" class="border p-1 rounded">
          <option value="AM">AM</option>
          <option value="PM">PM</option>
        </select>
      </div>
      <div class="mt-2">
        <select v-model="endHour" class="border p-1 rounded">
          <option v-for="hour in hours" :key="hour" :value="hour">{{ hour }}</option>
        </select>
        <select v-model="endMinute" class="border p-1 rounded mx-2">
          <option value="0">00</option>
          <option value="30">30</option>
        </select>
        <select v-model="endAmPm" class="border p-1 rounded">
          <option value="AM">AM</option>
          <option value="PM">PM</option>
        </select>
      </div>
      <button @click="saveHours" class="mt-2 text-blue-600">Save</button>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import axios from 'axios'; // Import Axios

// Retrieve user data from local storage
const getUserData = localStorage.getItem('user_data');
const parsedUserData = getUserData ? JSON.parse(getUserData) : {};
const userData = ref(parsedUserData);

// Ref for editing state
const isEditing = ref(false);

// Predefined hours for dropdown
const hours = Array.from({ length: 12 }, (_, i) => i + 1);

// Initialize start and end time values
const startHour = ref(userData.value.work_days.start_time ? parseInt(userData.value.work_days.start_time % 12) : 0);
const startMinute = ref(userData.value.work_days.start_time ? (userData.value.work_days.start_time % 1) * 60 : 0);
const startAmPm = ref(userData.value.work_days.start_time >= 12 ? 'PM' : 'AM');

const endHour = ref(userData.value.work_days.end_time ? parseInt(userData.value.work_days.end_time % 12) : 0);
const endMinute = ref(userData.value.work_days.end_time ? (userData.value.work_days.end_time % 1) * 60 : 0);
const endAmPm = ref(userData.value.work_days.end_time >= 12 ? 'PM' : 'AM');

// Format hours from 12-hour integer format to string
const formatTime = (hour, minute, ampm) => {
  if (hour === undefined || minute === undefined) return '';
  const formattedHour = hour % 12 || 12; // Convert to 12-hour format
  return `${formattedHour}:${minute < 10 ? '0' : ''}${minute} ${ampm}`;
};

// Computed properties for formatted start and end times
const formattedStartTime = computed(() => formatTime(startHour.value, startMinute.value, startAmPm.value));
const formattedEndTime = computed(() => formatTime(endHour.value, endMinute.value, endAmPm.value));

// Toggle edit mode
const toggleEditMode = () => {
  if (isEditing.value) {
    // Reset to original values
    startHour.value = userData.value.work_days.start_time ? parseInt(userData.value.work_days.start_time % 12) : 0;
    startMinute.value = userData.value.work_days.start_time ? (userData.value.work_days.start_time % 1) * 60 : 0;
    startAmPm.value = userData.value.work_days.start_time >= 12 ? 'PM' : 'AM';

    endHour.value = userData.value.work_days.end_time ? parseInt(userData.value.work_days.end_time % 12) : 0;
    endMinute.value = userData.value.work_days.end_time ? (userData.value.work_days.end_time % 1) * 60 : 0;
    endAmPm.value = userData.value.work_days.end_time >= 12 ? 'PM' : 'AM';
  }
  isEditing.value = !isEditing.value;
};

// Save hours to user data and send PUT request
const saveHours = async () => {
  const startIn24Hour = (startHour.value % 12) + (startAmPm.value === 'PM' ? 12 : 0) + (startMinute.value / 60);
  const endIn24Hour = (endHour.value % 12) + (endAmPm.value === 'PM' ? 12 : 0) + (endMinute.value / 60);
  
  userData.value.work_days.start_time = startIn24Hour;
  userData.value.work_days.end_time = endIn24Hour;
  
  // Store updated user data
  localStorage.setItem('user_data', JSON.stringify(userData.value));
  
  // Send PUT request to update the hours in the backend
  try {
    const response = await axios.put('/api/update-hours', {
      start_time: startIn24Hour,
      end_time: endIn24Hour
    });
    console.log('Hours updated successfully:', response.data);
  } catch (error) {
    console.error('Error updating hours:', error);
  }
  
  isEditing.value = false; // Exit edit mode
};
</script>
