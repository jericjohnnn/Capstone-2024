<template>
  <div class="register-container flex flex-col items-center justify-start mt-10 h-screen text-center p-5 rounded-md">
    <div class="bg-gray-300 px-4 rounded-xl flex pb-2">
      <div class="pb-5">
        <h2 class="py-5 font-bold text-xl">Sign-up as TUTOR</h2>

        <!-- Stepper -->
        <div class="flex justify-center mb-4">
          <ul class="flex flex-row gap-x-2 items-center">
            <li v-for="step in steps" :key="step.id" class="group flex items-center">
              <div class="flex items-center">
                <!-- Step circle with dynamic classes -->
                <span :class="{
                  'bg-blue-400 text-white': currentStep >= step.id, // Highlight current step and previous steps
                  'bg-gray-100 text-black': currentStep < step.id, // Default state for future steps
                }" class="size-7 flex justify-center items-center shrink-0 font-medium rounded-full">
                  {{ step.id }}
                </span>
                <!-- Line between steps (only for non-last steps) -->
                <div class="ms-2 w-20 h-px bg-gray-200 dark:bg-neutral-700 group-last:hidden"></div>
              </div>
            </li>
          </ul>
        </div>
        <!-- End Stepper -->

        <div class="flex justify-center">
          <form @submit.prevent="handleSubmit" class="flex flex-col gap-4 w-[390px] max-w-md">
            <!-- Step 2: Personal Information -->
            <div v-if="currentStep === 1" class="input-group flex flex-wrap gap-4">
              <div class="font-bold tex-xl">Personal Information</div>
              <input type="text" v-model="form.firstName" placeholder="First name" required
                class="input rounded-md w-full h-12 text-sm px-4" />
              <input type="text" v-model="form.lastName" placeholder="Last name" required
                class="input rounded-md w-full h-12 text-sm px-4" />
              <input type="text" v-model="form.address" placeholder="Address" required
                class="input rounded-md w-full h-12 text-sm px-4" />
              <input type="date" v-model="form.birthdate" placeholder="Birthdate" required
                class="input rounded-md w-full h-12 text-sm px-4 text-gray-600" />
              <select v-model="form.gender" required class="input rounded-md w-full h-12 text-sm px-4">
                <option value="" disabled>Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
              </select>
            </div>

            <!-- Step 3: Education Information and Subject Selection -->
            <div v-if="currentStep === 2" class="input-group flex flex-wrap gap-4">
              <div class="font-bold tex-xl">
                Education Information and Subject Selection
              </div>

              <!-- Education Information -->
              <input type="text" v-model="form.schoolIdNumber" placeholder="School ID Number" required
                class="input rounded-md w-full h-12 text-sm px-4" />
              <select v-model="form.course" required class="input rounded-md w-full h-12 text-sm px-4">
                <option value="" disabled>Select Course</option>
                <option value="BSED">BSED</option>
                <option value="BEED">BEED</option>
                <option value="BSIT">BSIT</option>
                <option value="BSHM">BSHM</option>
                <option value="BSENTREP">BSENTREP</option>
              </select>
              <select v-model="form.year" required class="input rounded-md w-full h-12 text-sm px-4">
                <option value="" disabled>Select Year</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>

              <!-- Subject Selection -->
              <div class="flex flex-col">
                <div class="select-container flex items-center gap-2">
                  <select v-model="selectedSubjects" multiple
                    class="subject-select input rounded-md overflow-y-scroll h-10 w-[330px]">
                    <option v-for="subject in subjects" :key="subject.id" :value="subject.id" class="pb-2">
                      {{ subject.name }}
                    </option>
                  </select>
                  <button @click.prevent="addSelectedSubjects"
                    class="add-button bg-blue-500 text-white px-3 py-1 rounded-md">
                    Add
                  </button>
                </div>
                <div class="selected-subjects flex flex-wrap gap-2 mt-2">
                  <span v-for="subjectId in form.subjects" :key="subjectId"
                    class="subject-badge bg-white px-2 py-1 rounded-md flex items-center gap-1">
                    {{ getSubjectName(subjectId) }}
                    <button @click.prevent="removeSubject(subjectId)" class="remove-badge text-red-500">
                      ×
                    </button>
                  </span>
                </div>
              </div>
            </div>

            <!-- Step 1: Account Information -->
            <div v-if="currentStep === 3" class="input-group flex flex-wrap gap-4">
              <div class="font-bold tex-xl">Account Information</div>
              <input type="email" v-model="form.email" placeholder="Email" required
                class="input rounded-md w-full h-12 text-sm px-4" />
              <input type="password" v-model="form.password" placeholder="Password" required
                class="input rounded-md w-full h-12 text-sm px-4" />
              <input type="password" v-model="form.confirmPassword" placeholder="Confirm password" required
                class="input rounded-md w-full h-12 text-sm px-4" />
              <div class="space-x-3 px-4 py-3 rounded-md bg-gray-100 w-[390px]">
                <input type="checkbox" v-model="form.agreeToTerms" required class="checkbox rounded-md" />
                <label>I agree to
                  <a href="#" class="text-blue-500">Terms & Conditions</a></label>
              </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="button-group flex space-x-4">
              <button type="button" v-if="currentStep > 1" @click="prevStep"
                class="bg-blue-600 text-white hover:bg-blue-400 rounded-md py-1 justify-center w-20">
                Back
              </button>
              <button type="button" v-if="currentStep < 3" @click="nextStep"
                class="bg-blue-600 hover:bg-blue-400 text-white rounded-md py-1 justify-center w-20">
                Next
              </button>
              <button v-if="currentStep === 3" type="submit" :disabled="!form.agreeToTerms"
                class="text-white rounded-md py-1 justify-center w-20 transition-colors" :class="{
                  'bg-blue-600 hover:bg-blue-400 cursor-pointer':
                    form.agreeToTerms,
                  'bg-gray-400 cursor-not-allowed': !form.agreeToTerms,
                }">
                Sign-up
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'

const currentStep = ref(1)

const steps = ref([
  { id: 1, label: 'Account Information' },
  { id: 2, label: 'Personal Information' },
  { id: 3, label: 'Education Information' },
])

const form = reactive({
  email: '',
  password: '',
  confirmPassword: '',
  firstName: '',
  lastName: '',
  address: '',
  birthdate: '',
  gender: '',
  schoolIdNumber: '',
  course: '',
  year: '',
  agreeToTerms: false,
  subjects: [],
})

const selectedSubjects = ref([])

const subjects = ref([
  { id: 1, name: 'Math' },
  { id: 2, name: 'Science' },
  { id: 3, name: 'History' },
  { id: 4, name: 'English' },
])

const getSubjectName = id => {
  const subject = subjects.value.find(subject => subject.id === id)
  return subject ? subject.name : ''
}

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

const addSelectedSubjects = () => {
  selectedSubjects.value.forEach(subjectId => {
    if (!form.subjects.includes(subjectId)) {
      form.subjects.push(subjectId)
    }
  })
  selectedSubjects.value = []
}

const removeSubject = subjectId => {
  const index = form.subjects.indexOf(subjectId)
  if (index > -1) {
    form.subjects.splice(index, 1)
  }
}

const handleSubmit = () => {
  // Handle form submission logic
  alert('Form submitted!')
}
</script>
