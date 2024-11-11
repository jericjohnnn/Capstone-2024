<template>
  <div class="space-y-4 ">
    <div
      v-for="(school, index) in userData.schools"
      :key="school.id"
      class="flex bg-white p-6 rounded-lg outline"
    >
      <div v-if="!editingIndex.includes(index)" class="flex gap-8 h-20">
        <div class="">
          <span class="w-12 h-12  flex items-center justify-center">
            <img
              :src="schoolImage"
              alt="School Logo"
              class="w-12 h-12 object-cover mr-4"
            />
          </span>
        </div>
        <div class="">
          <p class="text-lg font-semibold text-gray-900">{{ school.name }}</p>
          <p class="text-sm text-gray-500 italic">{{ school.course }}</p>
          <p class="text-sm text-gray-600 mt-2">
            {{ formatDate(school.start_date) }} - {{ school.end_date ? formatDate(school.end_date) : 'Present' }}
          </p>
        </div>
        <div class="flex gap-4 mt-2">
          <button @click="editSchool(index)" class="text-blue-600">Edit</button>
          <button @click="deleteSchool(school.id, index)" class="text-red-600">Delete</button>
        </div>
      </div>

      <div v-else class="flex gap-7 items-center h-28 ">
        <div class=" flex items-center justify-center w-12 h-12 rounded-full bg-gray-300">
          <i class="fas fa-school text-gray-500"></i>
        </div>

        <div class=" flex flex-col gap-1">
          <input type="text" v-model="school.name" placeholder="School Name" class="border rounded p-1 text-sm" />
          <input type="text" v-model="school.course" placeholder="Course" class="border rounded p-1 text-sm" />
          <div class="flex gap-1">
            <input type="date" v-model="school.start_date" class="border rounded p-1 text-sm" />
            <input type="date" v-model="school.end_date" class="border rounded p-1 text-sm" />
          </div>
        </div>
        <div class="">
          <button @click="saveSchool(index)" class="text-blue-600">Save</button>
          <button @click="cancelEdit(index)" class="text-gray-500">Cancel</button>
        </div>
      </div>
    </div>

    <button @click="addNewSchool" class="p-2 bg-blue-600 text-white rounded">Add New Education</button>

    <div v-if="addingNew" class="bg-gray-100 p-4 rounded-lg outline">
      <input type="text" v-model="newSchool.name" placeholder="School Name" class="p-1 border rounded w-full mb-2" />
      <input type="text" v-model="newSchool.course" placeholder="Course" class="p-1 border rounded w-full mb-2" />
      <input type="date" v-model="newSchool.start_date" class="p-1 border rounded w-full mb-2" />
      <input type="date" v-model="newSchool.end_date" class="p-1 border rounded w-full mb-2" />
      <div class="flex gap-2">
        <button @click="saveNewSchool" class="text-blue-600">Save</button>
        <button @click="cancelNewSchool" class="text-gray-500">Cancel</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axiosInstance from '@/axiosInstance'
import schoolImage from '@/assets/school.png'

const getUserData = localStorage.getItem('user_data')
const parsedUserData = getUserData ? JSON.parse(getUserData) : {}
const userData = ref(parsedUserData)

const editingIndex = ref([])
const addingNew = ref(false)

const newSchool = ref({
  name: '',
  course: '',
  start_date: '',
  end_date: '',
})

const formatDate = date => {
  return new Intl.DateTimeFormat('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  }).format(new Date(date))
}

const editSchool = index => {
  if (!editingIndex.value.includes(index)) {
    editingIndex.value.push(index)
  }
}

const saveSchool = async index => {
  try {
    const school = { ...userData.value.schools[index] }
    const dataToSave = {
      id: school.id,
      name: school.name,
      course: school.course,
      start_date: school.start_date,
      end_date: school.end_date,
    }
    await axiosInstance.put(`/api/edit-school/${school.id}`, dataToSave)
    localStorage.setItem('user_data', JSON.stringify(userData.value))
    editingIndex.value = editingIndex.value.filter(i => i !== index)
  } catch (error) {
    console.error('Failed to update education:', error)
  }
}

const cancelEdit = index => {
  editingIndex.value = editingIndex.value.filter(i => i !== index)
}

const addNewSchool = () => {
  addingNew.value = true
}

const saveNewSchool = async () => {
  try {
    const dataToSave = { ...newSchool.value }
    const response = await axiosInstance.post('/api/add-school', dataToSave)
    userData.value.schools.push(response.data.school)
    localStorage.setItem('user_data', JSON.stringify(userData.value))
    addingNew.value = false
    newSchool.value = {
      name: '',
      course: '',
      start_date: '',
      end_date: '',
    }
  } catch (error) {
    console.error('Failed to add new education:', error)
  }
}

const cancelNewSchool = () => {
  addingNew.value = false
  newSchool.value = {
    name: '',
    course: '',
    start_date: '',
    end_date: '',
  }
}

const deleteSchool = async (id, index) => {
  try {
    await axiosInstance.delete(`/api/delete-school/${id}`)
    userData.value.schools.splice(index, 1)
    localStorage.setItem('user_data', JSON.stringify(userData.value))
  } catch (error) {
    console.error('Failed to delete education:', error)
  }
}
</script>

<style scoped>
/* Add any custom styling here */
</style>
