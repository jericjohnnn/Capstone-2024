<template>
  <div>
    <h2 class="flex justify-between items-center">
      <span>Subjects</span>
      <button @click="toggleEditMode" class="text-blue-500">
        {{ isEditing ? 'Cancel' : 'Edit' }}
      </button>
    </h2>

    <div class="flex gap-2">
      <span
        v-for="subject in subjects"
        :key="subject.id"
        class="flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full"
      >
        {{ subject.name }}
        <button v-if="isEditing" @click="removeSubject(subject.id)" class="ml-2 text-red-500">&times;</button>
      </span>
    </div>

    <div v-if="isEditing" class="mt-4">
      <select v-model="selectedSubject" class="border rounded">
        <option v-for="option in availableSubjects" :key="option.id" :value="option.id">
          {{ option.name }}
        </option>
      </select>
      <button @click="addSubject" class="ml-2 bg-blue-500 text-white px-2 rounded">Add</button>
      <button @click="saveChanges" class="ml-2 bg-green-500 text-white px-2 rounded">Save</button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axiosInstance from '@/axiosInstance';

const userData = ref(JSON.parse(localStorage.getItem('user_data') || '{}'));
const subjects = ref(userData.value.subjects || []);
const isEditing = ref(false);
const originalSubjects = ref([]);
// const newSubjects = ref([])
const availableSubjects = ref([]);
const selectedSubject = ref(null);

const fetchSubjects = async () => {
  try {
    const { data } = await axiosInstance.get('/api/subjects');
    availableSubjects.value = data.subjects;
  } catch (error) {
    console.error('Error fetching subjects:', error);
  }
};


const toggleEditMode = () => {
  if (isEditing.value) {
    subjects.value = [...originalSubjects.value];
  } else {
    originalSubjects.value = [...subjects.value];
  }
  isEditing.value = !isEditing.value;
};

const removeSubject = (subjectId) => {
  subjects.value = subjects.value.filter(subject => subject.id !== subjectId);
};

const addSubject = () => {
  const subjectToAdd = availableSubjects.value.find(subject => subject.id === selectedSubject.value);
  if (subjectToAdd && !subjects.value.some(subject => subject.id === subjectToAdd.id)) {
    subjects.value.push(subjectToAdd);
  }
};

const saveChanges = async () => {
  try {
    const response = await axiosInstance.put('/api/edit-subjects', { subjects: subjects.value.map(subject => subject.id) });
    if (response.status === 200) {
      originalSubjects.value = [...subjects.value];
      userData.value.subjects = subjects.value;
      localStorage.setItem('user_data', JSON.stringify(userData.value));
      isEditing.value = !isEditing.value;
    }
  } catch (error) {
    console.error('Error saving subjects:', error);
    subjects.value = [...originalSubjects.value];
    alert('There was an error saving subjects.');
  }
};

onMounted(fetchSubjects);
</script>

<style scoped>
/* Add any additional styles here */
</style>
