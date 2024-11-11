<template>
  <div class="mb-6">
    <h3 class="font-medium mb-2">
      Days available:
      <button @click="toggleEditMode" class="ml-2 text-blue-600">{{ isEditing ? 'Cancel' : 'Edit' }}</button>
    </h3>
    <div v-if="!isEditing">
      <div v-for="day in availableDays" :key="day" class="flex gap-2">
        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full">{{ day }}</span>
      </div>
    </div>
    <div v-else>
      <div v-for="day in daysOfWeek" :key="day" class="flex gap-2">
        <input
          type="checkbox"
          :value="day"
          v-model="selectedDays"
        />
        <label>{{ day.charAt(0).toUpperCase() + day.slice(1) }}</label>
      </div>
      <button @click="saveDays" class="mt-2 text-blue-600">Save</button>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import axiosInstance from '@/axiosInstance'

// Retrieve user data from local storage
const getUserData = localStorage.getItem('user_data');
const parsedUserData = getUserData ? JSON.parse(getUserData) : {};
const userData = ref(parsedUserData);

const daysOfWeek = [
  'monday',
  'tuesday',
  'wednesday',
  'thursday',
  'friday',
  'saturday',
  'sunday',
];

const availableDays = computed(() => {
  if (!userData.value.work_days || Object.keys(userData.value.work_days).length === 0) {
    return [];
  }
  return daysOfWeek.filter(day => userData.value.work_days[day]);
});

const isEditing = ref(false);
const selectedDays = ref([...availableDays.value]);

const toggleEditMode = () => {
  if (isEditing.value) {
    selectedDays.value = [...availableDays.value];
  } else {
    selectedDays.value = [];
  }
  isEditing.value = !isEditing.value;
};

const saveDays = async () => {
  // Create an object to hold the days in the format you need
  const daysData = {};
  daysOfWeek.forEach(day => {
    daysData[day] = selectedDays.value.includes(day) ? 1 : 0; // Set to 1 if selected, otherwise 0
  });

  try {
    // Make a PUT request to update the days
    const response = await axiosInstance.put('/api/edit-work-days', daysData); // Replace with your API endpoint
    userData.value.work_days = response.data.work_days; // Update local state with the new values
    localStorage.setItem('user_data', JSON.stringify(userData.value)); // Save updated data to local storage
    isEditing.value = false; // Exit edit mode
  } catch (error) {
    console.error('Error saving days:', error); // Handle any errors that occur during the request
  }
};
</script>
