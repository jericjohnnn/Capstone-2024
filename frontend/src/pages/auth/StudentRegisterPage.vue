<template>
  <NavBar />
  <div class="min-h-[calc(100vh-5rem)] bg-gradient-to-b from-blue-50 to-white py-8 px-4">
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-lg">
      <div class="p-8">
        <!-- Header -->
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
          Sign up as <span class="text-blue-600">STUDENT</span>
        </h2>

        <!-- Stepper -->
        <div class="mb-8">
          <ul class="flex justify-center items-center">
            <li v-for="step in steps" :key="step.id" 
                class="group flex items-center">
              <div class="flex items-center">
                <span :class="{
                  'bg-blue-600 text-white ring-2 ring-blue-100': currentStep >= step.id,
                  'bg-gray-100 text-gray-600': currentStep < step.id,
                }" 
                class="h-8 w-8 flex justify-center items-center rounded-full font-semibold text-sm transition-all duration-200">
                  {{ step.id }}
                </span>
                <div class="mx-4 h-0.5 w-20 bg-gray-200 group-last:hidden"></div>
              </div>
            </li>
          </ul>
        </div>

        <!-- Form -->
        <form @submit.prevent="handleSubmit" class="max-w-md mx-auto">
          <!-- Step 1: Personal Information -->
          <div v-if="currentStep === 1" class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Personal Information</h3>
            <div class="grid grid-cols-2 gap-4">
              <input type="text" v-model="form.firstName" placeholder="First name" required 
                     class="col-span-1 h-11 px-4 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all duration-200" />
              <input type="text" v-model="form.lastName" placeholder="Last name" required 
                     class="col-span-1 h-11 px-4 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all duration-200" />
            </div>
            <input type="text" v-model="form.address" placeholder="Address" required 
                   class="w-full h-11 px-4 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all duration-200" />
            <input type="date" v-model="form.birthdate" required 
                   class="w-full h-11 px-4 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all duration-200 text-gray-600" />
          </div>

          <!-- Step 2: Other Details -->
          <div v-if="currentStep === 2" class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Other Details</h3>
            <input type="text" v-model="form.contactNo" placeholder="Contact Number" required 
                   class="w-full h-11 px-4 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all duration-200" />
            <input type="text" v-model="form.schoolIdNo" placeholder="School ID Number" required 
                   class="w-full h-11 px-4 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all duration-200" />
            <select 
              v-model="form.gradeYear" 
              required 
              class="w-full h-11 px-4 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all duration-200 bg-white text-gray-700"
            >
              <option value="" disabled selected>Select Grade Year</option>
              <option value="Grade 1">Grade 1</option>
              <option value="Grade 2">Grade 2</option>
              <option value="Grade 3">Grade 3</option>
              <option value="Grade 4">Grade 4</option>
              <option value="Grade 5">Grade 5</option>
              <option value="Grade 6">Grade 6</option>
              <option value="Grade 7">Grade 7</option>
              <option value="Grade 8">Grade 8</option>
              <option value="Grade 9">Grade 9</option>
              <option value="Grade 10">Grade 10</option>
              <option value="Grade 11">Grade 11</option>
              <option value="Grade 12">Grade 12</option>
            </select>
          </div>

          <!-- Step 3: Account Information -->
          <div v-if="currentStep === 3" class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Account Information</h3>
            <input type="email" v-model="form.email" placeholder="Email" required 
                   class="w-full h-11 px-4 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all duration-200" />
            <input type="password" v-model="form.password" placeholder="Password" required 
                   class="w-full h-11 px-4 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all duration-200" />
            <input type="password" v-model="form.confirmPassword" placeholder="Confirm password" required 
                   class="w-full h-11 px-4 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all duration-200" />
            
            <div class="p-4 bg-gray-50 rounded-lg">
              <label class="flex items-center space-x-3 cursor-pointer">
                <input type="checkbox" v-model="form.agreeToTerms" required 
                       class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500" />
                <span class="text-sm text-gray-600">
                  I agree to <a href="#" class="text-blue-600 hover:text-blue-700">Terms & Conditions</a>
                </span>
              </label>
            </div>
          </div>

          <!-- Navigation Buttons -->
          <div class="flex justify-end space-x-3 mt-8">
            <button type="button" v-if="currentStep > 1" @click="prevStep"
                    class="px-6 py-2.5 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
              Back
            </button>
            <button type="button" v-if="currentStep < 3" @click="nextStep"
                    class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-200">
              Next
            </button>
            <button v-if="currentStep === 3" type="submit" :disabled="!form.agreeToTerms"
                    class="px-6 py-2.5 text-sm font-medium rounded-lg transition-colors duration-200"
                    :class="form.agreeToTerms ? 'text-white bg-blue-600 hover:bg-blue-700' : 'text-gray-400 bg-gray-100 cursor-not-allowed'">
              Sign up
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <FooterSection />
</template>

<script setup>
import NavBar from '../../sections/NavBar.vue';
import FooterSection from '../../sections/FooterSection.vue';
import axiosInstance from '@/axiosInstance';
import router from '@/router';
import { reactive, ref } from 'vue'

const currentStep = ref(1)

const steps = ref([
  { id: 1, label: 'Account Information' },
  { id: 2, label: 'Personal Information' },
  { id: 3, label: 'Course and Subjects Selection' },
])

const form = reactive({
  email: '',
  password: '',
  confirmPassword: '',
  firstName: '',
  lastName: '',
  address: '',
  birthdate: '',
  contactNo: '',
  schoolIdNo: '',
  gradeYear: '',
  agreeToTerms: false,
})



const nextStep = () => {
  if (currentStep.value < steps.value.length) {
    currentStep.value++
  }
}

const prevStep = () => {
  if (currentStep.value > 1) {
    currentStep.value--
  }
}



const handleSubmit = async () => {
  if (form.password !== form.confirmPassword) {
    alert('Passwords do not match!')
    return
  }

  const payload = {
    user_type_id: 1,
    email: form.email,
    password: form.password,
    password_confirmation: form.confirmPassword,
    first_name: form.firstName,
    last_name: form.lastName,
    address: form.address,
    birthdate: form.birthdate,
    school_id_number: form.schoolIdNo,
    grade_year: form.gradeYear,
    contact_number: form.contactNo,
  }

  try {
    const response = await axiosInstance.post('api/register', payload)
    const { message, user_email, user_full_name, user_type, user_data, token } =
      response.data
    alert(message)
    localStorage.setItem('app_auth_token', token)
    localStorage.setItem('user_type', user_type)
    localStorage.setItem('user_email', user_email)
    localStorage.setItem('user_full_name', user_full_name)
    localStorage.setItem('user_data', JSON.stringify(user_data));
    router.push('/student/home')
  } catch (error) {
    alert(
      'Registration failed: ' +
        (error.response?.data?.message || error.message),
    )
  }
}
</script>

<style scoped>
.input {
  padding-left: 10px;
}

.subject-select {
  max-height: 200px;
  overflow-y: scroll;
}

.add-button {
  padding: 5px 10px;
  background-color: #4c9aff;
  border-radius: 4px;
  cursor: pointer;
}

.subject-badge {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.remove-badge {
  cursor: pointer;
}
</style>
