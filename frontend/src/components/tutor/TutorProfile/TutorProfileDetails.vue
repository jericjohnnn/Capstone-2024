<template>
  <div>
    <h3 class="mt-4 font-semibold">Personal Details:</h3>
    <button @click="toggleEditMode" class="ml-2 text-blue-600">
      {{ isEditing ? 'Cancel' : 'Edit' }}
    </button>
    <ul class="mt-2 space-y-1 text-sm text-gray-700">
      <li v-if="!isEditing">{{ formatDate(userData.birthdate) }}</li>
      <li v-else>
        <input
          type="date"
          v-model="birthdate"
          class="border rounded px-2 py-1"
        />
      </li>
      <li v-if="!isEditing">{{ userData.address }}</li>
      <li v-else>
        <input type="text" v-model="address" class="border rounded px-2 py-1" />
      </li>
      <li v-if="!isEditing">{{ userData.contact_number }}</li>
      <li v-else>
        <input
          type="text"
          v-model="contactNumber"
          class="border rounded px-2 py-1"
        />
      </li>
    </ul>
    <div v-if="isEditing">
      <button @click="saveDetails" class="mt-2 text-blue-600">Save</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axiosInstance from '@/axiosInstance'
import { formatDate } from '@/utils/dateTime'
import { getUserData } from '@/utils/user'

const userData = getUserData()

const birthdate = ref(userData.value.birthdate)
const address = ref(userData.value.address)
const contactNumber = ref(userData.value.contact_number)
const isEditing = ref(false)

const toggleEditMode = () => {
  if (isEditing.value) {
    birthdate.value = userData.value.birthdate
    address.value = userData.value.address
    contactNumber.value = userData.value.contact_number
  }
  isEditing.value = !isEditing.value
}

const saveDetails = async () => {
  try {
    const data = {
      birthdate: birthdate.value,
      address: address.value,
      contact_number: contactNumber.value,
    }

    await axiosInstance.post('api/edit-details', data)

    userData.value.birthdate = data.birthdate
    userData.value.address = data.address
    userData.value.contact_number = data.contact_number
    localStorage.setItem('user_data', JSON.stringify(userData.value))

    isEditing.value = false
  } catch (error) {
    console.error('Error saving personal details:', error)
  }
}
</script>
