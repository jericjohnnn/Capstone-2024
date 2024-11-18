<template>
  <div v-if="isEditModalVisible" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center z-50">
  <div class="bg-white p-6 rounded-md shadow-lg w-full max-w-md overflow-hidden">
    <h3 class="text-xl mb-4 text-center font-medium">Edit Profile</h3>
    <form @submit.prevent="saveEdits">

         <!-- Profile Image Upload -->
      <div class="flex flex-row space-x-3  items-center mb-4">
        <img v-if="editData.profile_image" :src="editData.profile_image" alt="Profile Image Preview" class="w-32 h-32 object-cover rounded-full border border-gray-400 shadow-md mb-3" />
        <input type="file" @change="onImageChange" accept="image/*" class="text-sm text-gray-600" />
      </div>
      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label for="first_name" class="block text-gray-700">First Name</label>
          <input v-model="editData.first_name" type="text" id="first_name" class="w-full mt-1 px-3 py-2 border rounded-md text-sm" />
        </div>
        <div>
          <label for="last_name" class="block text-gray-700">Last Name</label>
          <input v-model="editData.last_name" type="text" id="last_name" class="w-full mt-1 px-3 py-2 border rounded-md text-sm" />
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label for="address" class="block text-gray-700">Address</label>
          <input v-model="editData.address" type="text" id="address" class="w-full mt-1 px-3 py-2 border rounded-md text-sm" />
        </div>
        <div>
          <label for="birthdate" class="block text-gray-700">Birthdate</label>
          <input v-model="editData.birthdate" type="date" id="birthdate" class="w-full mt-1 px-3 py-2 border rounded-md text-sm" />
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label for="contact_number" class="block text-gray-700">Contact Number</label>
          <input v-model="editData.contact_number" type="text" id="contact_number" class="w-full mt-1 px-3 py-2 border rounded-md text-sm" />
        </div>
        <div>
          <label for="school_id_number" class="block text-gray-700">School ID Number</label>
          <input v-model="editData.school_id_number" type="text" id="school_id_number" class="w-full mt-1 px-3 py-2 border rounded-md text-sm" />
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label for="grade_year" class="block text-gray-700">Grade Year</label>
          <input v-model="editData.grade_year" type="text" id="grade_year" class="w-full mt-1 px-3 py-2 border rounded-md text-sm" />
        </div>
      </div>

      <div class="flex justify-between space-x-4 mt-6">
        <button @click="toggleEditMode" type="button" class="bg-gray-400 hover:bg-gray-500  text-white px-6 py-2 rounded-md text-sm">Cancel</button>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md text-sm">Save</button>
      </div>
    </form>
  </div>
</div>

</template>

<script setup>
defineProps({
  isEditModalVisible: Boolean,
  editData: Object,
  onClose: Function,
  onSave: Function
})
</script>
