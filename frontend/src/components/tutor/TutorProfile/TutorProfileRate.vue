<template>
  <div class="mb-6">
    <h3 class="font-medium mb-2">
      Tutor Rate:
      <button @click="toggleEditMode" class="ml-2 text-blue-600">{{ isEditing ? 'Cancel' : 'Edit' }}</button>
    </h3>
    <div v-if="!isEditing">
      <p class="text-blue-500">P{{ userData.tutor_rate }}/Session</p>
    </div>
    <div v-else>
      <input
        type="number"
        v-model.number="tutorRate"
        class="border rounded px-2 py-1 text-black"
        min="0"
      />
      <button @click="saveTutorRate" class="mt-2 text-blue-600">Save</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axiosInstance from '@/axiosInstance'
import { getUserData } from '@/utils/user'

const userData = getUserData()

const tutorRate = ref(userData.value.tutor_rate || 0);
const isEditing = ref(false);

const toggleEditMode = () => {
  if (isEditing.value) {
    tutorRate.value = userData.value.tutor_rate;
  } else {
    tutorRate.value = userData.value.tutor_rate;
  }
  isEditing.value = !isEditing.value;
};


const saveTutorRate = async () => {
  try {
    const data = {
      tutor_rate: Math.floor(tutorRate.value)
    };

    await axiosInstance.post('/api/edit-details', data);

    userData.value.tutor_rate = data.tutor_rate;
    localStorage.setItem('user_data', JSON.stringify(userData.value));
    isEditing.value = false;
  } catch (error) {
    console.error('Error saving tutor rate:', error);
  }
};
</script>
