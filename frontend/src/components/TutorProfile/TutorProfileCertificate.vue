<template>
  <div class="space-y-4 ">
    <div
      v-for="(certificate, index) in userData.certificates"
      :key="certificate.id"
      class="flex bg-white p-6 rounded-lg outline"
    >
      <div v-if="!editingIndex.includes(index)" class="flex gap-8 h-20">
        <div class="">
          <span class="w-10 h-10  flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M173.8 5.5c11-7.3 25.4-7.3 36.4 0L228 17.2c6 3.9 13 5.8 20.1 5.4l21.3-1.3c13.2-.8 25.6 6.4 31.5 18.2l9.6 19.1c3.2 6.4 8.4 11.5 14.7 14.7L344.5 83c11.8 5.9 19 18.3 18.2 31.5l-1.3 21.3c-.4 7.1 1.5 14.2 5.4 20.1l11.8 17.8c7.3 11 7.3 25.4 0 36.4L366.8 228c-3.9 6-5.8 13-5.4 20.1l1.3 21.3c.8 13.2-6.4 25.6-18.2 31.5l-19.1 9.6c-6.4 3.2-11.5 8.4-14.7 14.7L301 344.5c-5.9 11.8-18.3 19-31.5 18.2l-21.3-1.3c-7.1-.4-14.2 1.5-20.1 5.4l-17.8 11.8c-11 7.3-25.4 7.3-36.4 0L156 366.8c-6-3.9-13-5.8-20.1-5.4l-21.3 1.3c-13.2 .8-25.6-6.4-31.5-18.2l-9.6-19.1c-3.2-6.4-8.4-11.5-14.7-14.7L39.5 301c-11.8-5.9-19-18.3-18.2-31.5l1.3-21.3c.4-7.1-1.5-14.2-5.4-20.1L5.5 210.2c-7.3-11-7.3-25.4 0-36.4L17.2 156c3.9-6 5.8-13 5.4-20.1l-1.3-21.3c-.8-13.2 6.4-25.6 18.2-31.5l19.1-9.6C65 70.2 70.2 65 73.4 58.6L83 39.5c5.9-11.8 18.3-19 31.5-18.2l21.3 1.3c7.1 .4 14.2-1.5 20.1-5.4L173.8 5.5zM272 192a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM1.3 441.8L44.4 339.3c.2 .1 .3 .2 .4 .4l9.6 19.1c11.7 23.2 36 37.3 62 35.8l21.3-1.3c.2 0 .5 0 .7 .2l17.8 11.8c5.1 3.3 10.5 5.9 16.1 7.7l-37.6 89.3c-2.3 5.5-7.4 9.2-13.3 9.7s-11.6-2.2-14.8-7.2L74.4 455.5l-56.1 8.3c-5.7 .8-11.4-1.5-15-6s-4.3-10.7-2.1-16zm248 60.4L211.7 413c5.6-1.8 11-4.3 16.1-7.7l17.8-11.8c.2-.1 .4-.2 .7-.2l21.3 1.3c26 1.5 50.3-12.6 62-35.8l9.6-19.1c.1-.2 .2-.3 .4-.4l43.2 102.5c2.2 5.3 1.4 11.4-2.1 16s-9.3 6.9-15 6l-56.1-8.3-32.2 49.2c-3.2 5-8.9 7.7-14.8 7.2s-11-4.3-13.3-9.7z"/></svg>
          </span>
        </div>
        <div class="">
          <p class="text-lg font-semibold text-gray-900">{{ certificate.title }}</p>
          <p class="text-sm text-gray-500 italic">{{ certificate.issuer }}</p>
          <p class="text-sm text-gray-600 mt-2">{{ formatDate(certificate.date_issued) }}</p>
        </div>
        <div class="flex gap-4 mt-2">
          <button @click="editCertificate(index)" class="text-blue-600">Edit</button>
          <button @click="deleteCertificate(certificate.id, index)" class="text-red-600">Delete</button>
        </div>
      </div>

      <div v-else class="flex gap-7 items-center h-28 ">
        <div class=" flex items-center justify-center w-12 h-12 rounded-full bg-gray-300">
          <i class="fas fa-certificate text-gray-500"></i>
        </div>

        <div class=" flex flex-col gap-1">
          <input type="text" v-model="certificate.title" placeholder="Certificate Title" class="border rounded p-1 text-sm" />
          <input type="text" v-model="certificate.issuer" placeholder="Issuer" class="border rounded p-1 text-sm" />
          <input type="date" v-model="certificate.date_issued" class="border rounded p-1 text-sm" />
        </div>
        <div class="">
          <button @click="saveCertificate(index)" class="text-blue-600">Save</button>
          <button @click="cancelEdit(index)" class="text-gray-500">Cancel</button>
        </div>
      </div>
    </div>

    <button @click="addNewCertificate" class="p-2 bg-blue-600 text-white rounded">Add New Certificate</button>

    <div v-if="addingNew" class="bg-gray-100 p-4 rounded-lg outline">
      <input type="text" v-model="newCertificate.title" placeholder="Certificate Title" class="p-1 border rounded w-full mb-2" />
      <input type="text" v-model="newCertificate.issuer" placeholder="Issuer" class="p-1 border rounded w-full mb-2" />
      <input type="date" v-model="newCertificate.date_issued" class="p-1 border rounded w-full mb-2" />
      <div class="flex gap-2">
        <button @click="saveNewCertificate" class="text-blue-600">Save</button>
        <button @click="cancelNewCertificate" class="text-gray-500">Cancel</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axiosInstance from '@/axiosInstance'

const getUserData = localStorage.getItem('user_data')
const parsedUserData = getUserData ? JSON.parse(getUserData) : {}
const userData = ref(parsedUserData)

const editingIndex = ref([])
const addingNew = ref(false)

const newCertificate = ref({
  title: '',
  issuer: '',
  date_issued: '',
})

const formatDate = date => {
  return new Intl.DateTimeFormat('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  }).format(new Date(date))
}

const editCertificate = index => {
  if (!editingIndex.value.includes(index)) {
    editingIndex.value.push(index)
  }
}

const saveCertificate = async index => {
  try {
    const certificate = { ...userData.value.certificates[index] }
    const dataToSave = {
      id: certificate.id,
      title: certificate.title,
      issuer: certificate.issuer,
      date_issued: certificate.date_issued,
    }
    await axiosInstance.put(`/api/edit-certificate/${certificate.id}`, dataToSave)
    localStorage.setItem('user_data', JSON.stringify(userData.value))
    editingIndex.value = editingIndex.value.filter(i => i !== index)
  } catch (error) {
    console.error('Failed to update education:', error)
  }
}

const cancelEdit = index => {
  editingIndex.value = editingIndex.value.filter(i => i !== index)
}

const addNewCertificate = () => {
  addingNew.value = true
}

const saveNewCertificate = async () => {
  try {
    const dataToSave = { ...newCertificate.value }
    const response = await axiosInstance.post('/api/add-certificate', dataToSave)
    userData.value.certificates.push(response.data.certificate)
    localStorage.setItem('user_data', JSON.stringify(userData.value))
    addingNew.value = false
    newCertificate.value = {
      title: '',
      issuer: '',
      date_issued: '',
    }
  } catch (error) {
    console.error('Failed to add new education:', error)
  }
}

const cancelNewCertificate = () => {
  addingNew.value = false
  newCertificate.value = {
    title: '',
    issuer: '',
    date_issued: '',
  }
}

const deleteCertificate = async (id, index) => {
  try {
    await axiosInstance.delete(`/api/delete-certificate/${id}`)
    userData.value.certificates.splice(index, 1)
    localStorage.setItem('user_data', JSON.stringify(userData.value))
  } catch (error) {
    console.error('Failed to delete certificate:', error)
  }
}
</script>

<style scoped>
/* Add any custom styling here */
</style>
