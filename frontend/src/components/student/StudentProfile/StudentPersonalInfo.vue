<template>
  <div class="w-full border font-normal text-gray-600 bg-gray-200 border-neutral-400 rounded">
    <div class="px-7 py-4 border-b text-gray-700 font-semibold">
      Personal Information
      <button
        v-if="!isEditMode"
        @click="toggleEditMode"
        class="ml-4 px-2 py-1 text-xs text-white bg-blue-500 rounded hover:bg-blue-600"
      >
        Edit
      </button>
    </div>

    <div class="px-7 py-4 border-b text-xs">
      The information provided below will reflect on your invoices
    </div>

    <div v-if="isEditMode" class="px-7 py-4 border-b text-xs space-y-4">
      <input label="First Name" v-model="editableData.first_name" />
      <input label="Last Name" v-model="editableData.last_name" />
      <input label="Address" v-model="editableData.address" />
      <input label="Contact Number" v-model="editableData.contact_number" />
      
      <div class="flex justify-end gap-4">
        <button
          @click="cancelEdit"
          class="px-4 py-2 text-xs text-gray-600 bg-gray-200 rounded hover:bg-gray-300"
        >
          Cancel
        </button>
        <button
          @click="saveChanges"
          :disabled="isNoChangesMade"
          class="px-4 py-2 text-xs text-white bg-green-500 rounded hover:bg-green-600"
        >
          Save
        </button>
      </div>
    </div>

    <div v-else>
      <div class="grid grid-cols-2 gap-4 py-4 px-7 border-b text-xs items-center">
        Name
        <span class="font-semibold text-black">{{ editableData.first_name }} {{ editableData.last_name }}</span>
      </div>
      <div class="grid grid-cols-2 gap-4 py-4 px-7 border-b text-xs items-center">
        Address
        <span class="font-semibold text-black">{{ editableData.address }}</span>
      </div>
      <div class="grid grid-cols-2 gap-4 px-7 py-4 border-b text-xs items-center">
        Contact Number
        <span class="font-semibold text-black">{{ editableData.contact_number }}</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, watch, computed } from 'vue';
import axiosInstance from '@/axiosInstance';

const props = defineProps({
  userData: {
    type: Object,
    required: true,
  },
});

const isEditMode = ref(false);
const editableData = reactive({ ...props.userData });

watch(
  () => props.userData,
  (newVal) => {
    if (newVal) {
      Object.assign(editableData, newVal); 
    }
  },
  { immediate: true, deep: true }
);

const toggleEditMode = () => {
  isEditMode.value = true;
};

const saveChanges = async () => {
  try {
    const response = await axiosInstance.post('/api/edit-student-details', editableData);
    console.log("Edit saved:", response.data);
    // Emit the updated data to the parent
    emit('update:userData', editableData);
    isEditMode.value = false;
  } catch (error) {
    console.error("Error saving edits:", error);
  }
};

const cancelEdit = () => {
  if (props.userData) {
    Object.assign(editableData, props.userData); 
  }
  isEditMode.value = false;
};

const isNoChangesMade = computed(() => {
  return JSON.stringify(editableData) === JSON.stringify(props.userData);
});
</script>
