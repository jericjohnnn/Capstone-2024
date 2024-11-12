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
            <img
              :src="certificateImage"
              alt="Certificate Image"
              class="w-12 h-12 rounded-lg object-cover mr-4"
            />
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
import certificateImage from '@/assets/certificate.png'
import { formatDate } from '@/utils/dateTime'
import { getUserData } from '@/utils/user'

const userData = getUserData()

const editingIndex = ref([])
const addingNew = ref(false)

const newCertificate = ref({
  title: '',
  issuer: '',
  date_issued: '',
})

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
