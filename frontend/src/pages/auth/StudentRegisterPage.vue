<template>
  <div class="register-container flex flex-col items-center justify-start mt-10 h-screen text-center p-5 rounded-md">
    <div class="bg-gray-300 px-4 rounded-xl flex pb-2">
      <div class="pb-5">
        <h2 class="py-5 font-bold text-xl">Sign-up as STUDENT</h2>

        <!-- Stepper -->
        <div class="flex justify-center mb-4">
          <ul class="flex flex-row gap-x-2 items-center">
            <li v-for="step in steps" :key="step.id" class="group flex items-center">
              <div class="flex items-center">
                <!-- Step circle with dynamic classes -->
                <span :class="{
                  'bg-blue-500 text-white': currentStep >= step.id,
                  'bg-gray-100 text-black': currentStep < step.id,
                }" class="size-7 flex justify-center items-center shrink-0 font-medium rounded-full">
                  {{ step.id }}
                </span>
                <div class="ms-2 w-20 h-px bg-gray-200 dark:bg-neutral-700 group-last:hidden"></div>
              </div>
            </li>
          </ul>
        </div>

        <div class="flex justify-center">
          <form @submit.prevent="handleSubmit" class="flex flex-col gap-4 w-[390px] max-w-md">
            <!-- Step 1: Account Information -->
            

            <!-- Step 2: Personal Information -->
            <div v-if="currentStep === 1" class="input-group flex flex-wrap gap-4">
              <div class="font-bold tex-xl">Personal Information</div>
              <input type="text" v-model="form.firstName" placeholder="First name" required class="input rounded-md w-full h-12 text-sm px-4" />
              <input type="text" v-model="form.lastName" placeholder="Last name" required class="input rounded-md w-full h-12 text-sm px-4" />
              <input type="text" v-model="form.address" placeholder="Address" required class="input rounded-md w-full h-12 text-sm px-4" />
              <input type="date" v-model="form.birthdate" required class="input rounded-md w-full h-12 text-sm px-4 text-gray-600" />
            </div>

            <!-- Step 3: Course and Subjects Selection -->
            <div v-if="currentStep === 2 " class="input-group flex flex-wrap gap-4">
              <div class="font-bold tex-xl">Other Details</div>
              <input type="text" v-model="form.contactNo" placeholder="Contact Number" required class="input rounded-md w-full h-12 text-sm px-4" />
              <input type="text" v-model="form.schoolIdNo" placeholder="School Id Number" required class="input rounded-md w-full h-12 text-sm px-4" />
              <select v-model="form.gradeYear" required class="input rounded-md w-full h-12 text-sm px-4">
                <option value="" disabled>Grade Year</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>
            </div>

            <div v-if="currentStep === 3" class="input-group flex flex-wrap gap-4">
              <div class="font-bold tex-xl">Account Information</div>
              <input type="email" v-model="form.email" placeholder="Email" required class="input rounded-md w-full h-12 text-sm px-4" />
              <input type="password" v-model="form.password" placeholder="Password" required class="input rounded-md w-full h-12 text-sm px-4" />
              <input type="password" v-model="form.confirmPassword" placeholder="Confirm password" required class="input rounded-md w-full h-12 text-sm px-4" />
              <div class="space-x-3 px-4 py-3 rounded-md bg-gray-100 w-[390px]">
                <input type="checkbox" v-model="form.agreeToTerms" required class="checkbox rounded-md" />
                <label>I agree to <a href="#" class="text-blue-500">Terms & Conditions</a></label>
              </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="button-group flex space-x-4">
              <button type="button" v-if="currentStep > 1" @click="prevStep" class="bg-blue-600 text-white hover:bg-blue-400 rounded-md py-1 justify-center w-20">Back</button>
              <button type="button" v-if="currentStep < 3" @click="nextStep" class="bg-blue-600 hover:bg-blue-400 text-white rounded-md py-1 justify-center w-20">Next</button>
              <button v-if="currentStep === 3" type="submit" :disabled="!form.agreeToTerms" class="text-white rounded-md py-1 justify-center w-20 transition-colors" :class="{
                'bg-blue-600 hover:bg-blue-400 cursor-pointer': form.agreeToTerms,
                'bg-gray-400 cursor-not-allowed': !form.agreeToTerms
              }">Sign-up</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
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
  contactNumber: '',
  schoolIdNumber: '',
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
