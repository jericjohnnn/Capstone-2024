<template>
  <div>
    <div v-for="(school, index) in userData.schools" :key="school.id">
      <div v-if="!editingIndex.includes(index)">
        <img :src="school.image" alt="School Logo" />
        <p>{{ school.name }}</p>
        <p>{{ school.course }}</p>
        <p>{{ formatDate(school.start_date) }} - {{ school.end_date ? formatDate(school.end_date) : 'Present' }}</p>
        <button @click="editSchool(index)">Edit</button>
      </div>

      <div v-else>
        <input type="file" @change="handleFileUpload($event, index)" accept="image/*" />
        <input type="text" v-model="school.name" placeholder="School Name" />
        <input type="text" v-model="school.course" placeholder="Course" />
        <input type="date" v-model="school.start_date" />
        <input type="date" v-model="school.end_date" />
        <button @click="saveSchool(index)">Save</button>
        <button @click="cancelEdit(index)">Cancel</button>
      </div>
    </div>

    <button @click="addNewSchool">Add New Education</button>

    <div v-if="addingNew">
      <input type="text" v-model="newSchool.name" placeholder="School Name" />
      <input type="text" v-model="newSchool.course" placeholder="Course" />
      <input type="date" v-model="newSchool.start_date" />
      <input type="date" v-model="newSchool.end_date" />
      <input type="text" v-model="newSchool.image" placeholder="Image URL" />
      <button @click="saveNewSchool">Save</button>
      <button @click="cancelNewSchool">Cancel</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const userData = ref(JSON.parse(localStorage.getItem('user_data')) || { schools: [] })
const editingIndex = ref([])
const addingNew = ref(false)
const newSchool = ref({ name: '', course: '', start_date: '', end_date: '', image: '' })

const formatDate = date => {
  return new Intl.DateTimeFormat('en-US').format(new Date(date))
}

const handleFileUpload = async (event, index) => {
  const file = event.target.files[0]
  if (file) {
    const formData = new FormData()
    formData.append('image', file)
    try {
      const response = await axios.post('/api/upload', formData, { headers: { 'Content-Type': 'multipart/form-data' } })
      userData.value.schools[index].image = response.data.imageUrl
      localStorage.setItem('user_data', JSON.stringify(userData.value))
    } catch (error) {
      console.error('Failed to upload image:', error)
    }
  }
}

const editSchool = index => editingIndex.value.push(index)
const saveSchool = async index => {
  try {
    const school = userData.value.schools[index]
    await axios.put(`/api/education/${school.id}`, school)
    localStorage.setItem('user_data', JSON.stringify(userData.value))
    editingIndex.value = editingIndex.value.filter(i => i !== index)
  } catch (error) {
    console.error('Failed to update education:', error)
  }
}
const cancelEdit = index => editingIndex.value = editingIndex.value.filter(i => i !== index)
const addNewSchool = () => addingNew.value = true

const saveNewSchool = async () => {
  try {
    const response = await axios.post('/api/education', newSchool.value)
    userData.value.schools.push(response.data)
    localStorage.setItem('user_data', JSON.stringify(userData.value))
    addingNew.value = false
    newSchool.value = { name: '', course: '', start_date: '', end_date: '', image: '' }
  } catch (error) {
    console.error('Failed to add new education:', error)
  }
}

const cancelNewSchool = () => {
  addingNew.value = false
  newSchool.value = { name: '', course: '', start_date: '', end_date: '', image: '' }
}
</script>
