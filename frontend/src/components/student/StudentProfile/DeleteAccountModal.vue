<template>
  <div v-if="isDeleteModalVisible" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center z-50" role="dialog" aria-labelledby="deleteModalTitle" aria-describedby="deleteModalDescription">
    <div class="bg-white p-5 rounded-md shadow-lg w-96">
      <h3 id="deleteModalTitle" class="text-xl mb-4 text-center">Are you sure you want to delete your account?</h3>
      <p id="deleteModalDescription" class="text-center text-gray-600 mb-4">This action is irreversible, and all your data will be lost.</p>
      <div class="flex justify-center space-x-4">
        <button @click="onConfirm" class="bg-red-600 text-white px-6 py-2 rounded-md">Yes, Delete</button>
        <button @click="onClose" class="bg-gray-400 text-white px-6 py-2 rounded-md">Cancel</button>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  isDeleteModalVisible: Boolean,
  onClose: Function,
  onConfirm: Function
});
</script>
