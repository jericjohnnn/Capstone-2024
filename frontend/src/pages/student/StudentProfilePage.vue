<template>
  <main>
    <SideBar>
      <main class="container p-5 mx-auto">
        <p class="font-semibold text-xl">Account Information</p>
        
        <!-- Personal Information Section -->
        <StudentPersonalInfo 
          v-if="userData" 
          :userData="userData" 
          @update:userData="updateUserData" 
        />

        <!-- Profile and Other Data Section -->
        <StudentProfileData :userData="userData" />
        
        <!-- Account Settings Section -->
        <StudentAccountSetting @delete="openDeleteModal" />
      </main>
    </SideBar>

    <HelpButton />
  </main>

  <DeleteAccountModal
    v-if="isDeleteModalVisible"
    @onClose="closeDeleteModal"
    @onConfirm="deleteAccount"
  />
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axiosInstance from '@/axiosInstance'
import SideBar from '@/components/SideBar.vue'
import HelpButton from '@/components/HelpButton.vue'
import DeleteAccountModal from '@/components/student/StudentProfile/DeleteAccountModal.vue'
import StudentPersonalInfo from '@/components/student/StudentProfile/StudentPersonalInfo.vue'
import StudentProfileData from '@/components/student/StudentProfile/StudentProfileData.vue'
import StudentAccountSetting from '@/components/student/StudentProfile/StudentAccountSetting.vue'

// Reactive variables
const userData = ref(null);
const isDeleteModalVisible = ref(false);
const router = useRouter();

const storedUserData = localStorage.getItem('user_data');

// Fetch student data
const fetchStudentData = async () => {
  try {
    const response = await axiosInstance.get('/api/student-info');
    userData.value = response.data.student;
    localStorage.setItem('user_data', JSON.stringify(userData.value));
  } catch (err) {
    console.error('Error fetching student details:', err);
  }
};

// Fetch student data when the component is mounted
onMounted(fetchStudentData);

// Method to update the userData when changes are made in StudentPersonalInfo component
const updateUserData = (updatedData) => {
  userData.value = updatedData;
};

// Delete account logic
const openDeleteModal = () => {
  isDeleteModalVisible.value = true;
};

const closeDeleteModal = () => {
  isDeleteModalVisible.value = false;
};

const deleteAccount = async () => {
  try {
    await axiosInstance.delete('/api/delete-student-account');
    localStorage.removeItem('user_data');
    router.push('/');
    console.log('Account deleted');
    closeDeleteModal();
  } catch (error) {
    console.error('Error deleting account:', error);
  }
};
</script>
