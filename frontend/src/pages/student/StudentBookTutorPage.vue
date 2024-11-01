<template>
  <main class="p-4">
    <SideBar>
      <main class="container mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">
          <!-- Tutor Info -->
          <div class="flex items-center mb-4">
            <img
              :src="tutorDetails.profile_image"
              alt="Tutor"
              class="w-16 h-16 rounded-full"
            />
            <div class="ml-4">
              <h2 class="text-xl font-semibold">
                {{ tutorDetails.first_name }} {{ tutorDetails.last_name }}
              </h2>
              <div
                v-if="
                  !tutorDetails.subjects || tutorDetails.subjects.length === 0
                "
              >
                <p>No subjects</p>
              </div>
              <div v-else class="flex flex-wrap gap-1">
                <span
                  v-for="subject in tutorDetails.subjects"
                  :key="subject.id"
                  class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm"
                >
                  {{ subject.name }}
                </span>
              </div>
            </div>
          </div>

          <div class="text-sm text-gray-600 mb-4">
            <p
              v-if="
                !tutorDetails.work_days || tutorDetails.work_days.length === 0
              "
            >
              No availability
            </p>
            <p v-else>
              {{ tutorDetails.first_name }} {{ tutorDetails.last_name }} is
              available {{ tutorDetails.work_days.start_time }} -
              {{ tutorDetails.work_days.end_time }}
              <span class="float-right"
                >Rate: P{{ tutorDetails.tutor_rate }}/Hour</span
              >
            </p>
          </div>

          <div v-if="!tutorDetail">
            <p class="text-center text-gray-500">Select a Tutor</p>
          </div>
          <div v-else>
            <BookCalendar :tutorDetails="tutorDetails"></BookCalendar>
          </div>

          <!-- Booking Form -->
          <form @submit.prevent="handleSubmit" class="space-y-4">
            <div>
              <label class="block text-gray-700">Select subject:</label>
              <select
                v-model="selectedSubject"
                class="border rounded w-full p-2"
              >
                <option value="">Select Subject</option>
                <option
                  v-for="subject in tutorDetails.subjects"
                  :key="subject.id"
                  :value="subject.name"
                >
                  {{ subject.name }}
                </option>
              </select>
            </div>

            <div>
              <label class="block text-gray-700"
                >Choose mode of tutoring:</label
              >
              <select
                v-model="modeOfTutoring"
                class="border rounded w-full p-2"
              >
                <option value="In School">In School</option>
                <option value="Online">Online</option>
                <option value="Face to Face">Face to Face</option>
              </select>
            </div>

            <div>
              <label class="block text-gray-700">
                {{
                  modeOfTutoring === 'Online'
                    ? 'Select Video Conferencing Platform:'
                    : 'Location:'
                }}
              </label>

              <select
                v-if="modeOfTutoring === 'Online'"
                v-model="videoPlatform"
                class="border rounded w-full p-2"
              >
                <option value="Zoom">Zoom</option>
                <option value="Google Meet">Google Meet</option>
                <option value="Skype">Skype</option>
              </select>

              <input
                v-else-if="modeOfTutoring === 'Face to Face'"
                v-model="location"
                type="text"
                class="border rounded w-full p-2"
                placeholder="Enter location"
              />

              <div
                v-else
                class="border rounded w-full p-2 bg-gray-100 text-gray-700"
              >
                {{ location }}
              </div>
            </div>

            <div class="border rounded p-2">
              <label class="block text-gray-700">Message:</label>
              <input
                v-model="tutorTopic"
                class="w-full border-none outline-none mb-1"
                placeholder="Enter the topic that needs tutoring"
              />
              <textarea
                v-model="tutorMessage"
                class="w-full border-none outline-none mt-1 h-24 resize-none"
                placeholder="Enter objectives, concerns, and further details of your inquiry"
              ></textarea>
            </div>

            <div>
              <label class="block text-gray-700">Contact number:</label>
              <input
                v-model="contactNumber"
                type="text"
                class="border rounded w-full p-2"
                :readonly="isReadonly"
              />
              <div class="mt-2">
                <button
                  type="button"
                  class="text-blue-600 hover:underline mr-2"
                  @click="toggleEditing"
                >
                  {{ isReadonly ? 'Change number' : 'Apply' }}
                </button>
                <button
                  v-if="!isReadonly"
                  type="button"
                  class="text-green-600 hover:underline"
                  @click="cancelChanges"
                >
                  cancel
                </button>
              </div>
            </div>

            <div class="flex justify-end gap-4">
              <router-link :to="{ name: 'StudentHome' }">
                <button
                  type="button"
                  class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100"
                >
                  Cancel
                </button>
              </router-link>
              <button
                type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
              >
                BOOK
              </button>
            </div>
          </form>
        </div>
        <JamalModal></JamalModal>
      </main>
    </SideBar>

    <HelpButton />
  </main>
</template>

<script setup>
import JamalModal from '@/components/JamalModal.vue'
import SideBar from '@/components/SideBar.vue'
import HelpButton from '@/components/HelpButton.vue'
import { ref, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import axiosInstance from '@/axiosInstance'
import BookCalendar from '@/components/BookCalendar.vue'

const route = useRoute()
const tutorDetails = ref({})
const tutorDetail = ref(null)

const getUserData = localStorage.getItem('user_data')
const userData = getUserData ? JSON.parse(getUserData) : null
const studentContactNumber = userData ? userData.contact_number : null
const modifiedContactNumber = ref('')

const isReadonly = ref(true)

const selectedSubject = ref('')
const tutorTopic = ref('')
const tutorMessage = ref('')
const contactNumber = ref(studentContactNumber)
const modeOfTutoring = ref('In School')
const location = ref('CCTC')
const videoPlatform = ref('')

const toggleEditing = () => {
  isReadonly.value = !isReadonly.value
  modifiedContactNumber.value = contactNumber.value
}

const cancelChanges = () => {
  contactNumber.value = modifiedContactNumber.value
  isReadonly.value = true
}

const handleSubmit = async () => {
  console.log()
}

const fetchTutorDetails = async tutorId => {
  try {
    const response = await axiosInstance.get(`/api/tutor-detail/${tutorId}`)
    tutorDetails.value = response.data.tutor
    tutorDetail.value = response.data
  } catch (err) {
    console.error('Error fetching tutor details:', err)
  }
}

watch(modeOfTutoring, newMode => {
  if (newMode === 'In School') {
    location.value = 'CCTC'
  } else if (newMode === 'Face to Face') {
    location.value = ''
  }
})

onMounted(() => {
  const initialTutorId = route.params.tutorId
  if (initialTutorId) {
    fetchTutorDetails(initialTutorId)
  }
})
</script>
