<template>
  <div class="choose-role">
    <h2>Sign-up as: <span class="role-title">STUDENT</span> or <span class="role-title">TUTOR</span></h2>

    <div class="options">
      <div
        class="option"
        :class="{ selected: selectedRole === 'student' }"
        @click="selectRole('student')"
      >
        <h3>STUDENT</h3>
      </div>

      <div
        class="option"
        :class="{ selected: selectedRole === 'tutor' }"
        @click="selectRole('tutor')"
      >
        <h3>TUTOR</h3>
      </div>
    </div>

    <button class="continue-btn" :disabled="!selectedRole" @click="goToRegister">
      Continue
    </button>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const selectedRole = ref(''); // Holds the selected role

const selectRole = (role) => {
  selectedRole.value = role;
};

const goToRegister = () => {
  if (selectedRole.value === 'student') {
    router.push('/register/student'); // Redirect to student registration
  } else if (selectedRole.value === 'tutor') {
    router.push('/register/tutor'); // Redirect to tutor registration
  }
};
</script>

<style scoped>
.choose-role {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
  text-align: center;
}

.role-title {
  color: #4b8ff7;
  font-weight: bold;
}

.options {
  display: flex;
  gap: 2rem;
  margin-top: 20px;
}

.option {
  border: 2px solid #e0e0e0;
  border-radius: 10px;
  padding: 20px;
  width: 150px;
  cursor: pointer;
  transition: border-color 0.3s;
  text-align: center;
}

.option.selected {
  border-color: #4b8ff7;
}

img {
  width: 80px;
  height: 80px;
  margin-bottom: 10px;
}

.continue-btn {
  margin-top: 20px;
  padding: 10px 20px;
  background-color: #4b8ff7;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.continue-btn:disabled {
  background-color: #c0c0c0;
  cursor: not-allowed;
}

.continue-btn:hover:enabled {
  background-color: #3a7ddb;
}
</style>
