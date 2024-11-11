<template>
  <div>
    <!-- ========== MAIN CONTENT ========== -->
    <!-- Breadcrumb -->
    <div
      class="sticky top-0 inset-x-0 z-20 bg-white border-y px-4 sm:px-6 lg:px-8 lg:hidden dark:bg-neutral-800 dark:border-neutral-700"
    >
      <div class="flex items-center py-2">
        <!-- Navigation Toggle -->
        <button
          type="button"
          class="size-8 flex justify-center items-center gap-x-2 border border-gray-200 text-gray-800 hover:text-gray-500 rounded-lg focus:outline-none focus:text-gray-500 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-neutral-200 dark:hover:text-neutral-500 dark:focus:text-neutral-500"
          aria-haspopup="dialog"
          aria-expanded="false"
          aria-controls="hs-application-sidebar"
          aria-label="Toggle navigation"
          data-hs-overlay="#hs-application-sidebar"
        >
          <span class="sr-only">Toggle Navigation</span>
          <svg
            class="shrink-0 size-4"
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <rect width="18" height="18" x="3" y="3" rx="2" />
            <path d="M15 3v18" />
            <path d="m8 9 3 3-3 3" />
          </svg>
        </button>
        <!-- End Navigation Toggle -->

        <!-- Breadcrumb -->
        <ol class="ms-3 flex items-center whitespace-nowrap">
          <li
            class="flex items-center text-sm text-gray-800 dark:text-neutral-400"
          >
            App
            <svg
              class="shrink-0 mx-3 overflow-visible size-2.5 text-gray-400 dark:text-neutral-500"
              width="16"
              height="16"
              viewBox="0 0 16 16"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M5 1L10.6869 7.16086C10.8637 7.35239 10.8637 7.64761 10.6869 7.83914L5 14"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
              />
            </svg>
          </li>
          <li
            class="text-sm font-semibold text-gray-800 truncate dark:text-neutral-400"
            aria-current="page"
          >
            Home
          </li>
        </ol>
        <!-- End Breadcrumb -->
      </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Sidebar -->
    <div
      id="hs-application-sidebar"
      class="hs-overlay [--auto-close:lg] hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform w-[260px] h-full hidden fixed inset-y-0 start-0 z-[20] bg-blue-600 lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 dark:bg-neutral-800 dark:border-neutral-700"
      role="dialog"
      tabindex="-1"
      aria-label="Sidebar"
    >
      <div class="relative flex flex-col h-full max-h-full">
        <div class="px-8 pt-4">
          <!-- Logo -->
          <a
            class="flex-none rounded-md text-xl inline-block font-semibold focus:outline-none focus:opacity-80"
            href="#"
            aria-label="Preline"
          >
            <!-- LOGO SVG HERE OR ANYTHING -->
          </a>
          <!-- End Logo -->
        </div>

        <!-- Content -->
        <div
          class="h-full overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-md [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500"
        >
          <nav
            class="hs-accordion-group p-3 w-full flex flex-col flex-wrap h-full"
            data-hs-accordion-always-open
          >
            <!-- Main Navigation -->
            <div v-if="userType === 'Tutor'">
              <ul class="flex flex-col space-y-1">
                <li>
                  <router-link
                    active-class="active-nav"
                    class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-white rounded-md hover:bg-white/10 focus:outline-none focus:bg-white/10 dark:bg-neutral-700 dark:text-white transition-colors duration-200"
                    :to="{ name: 'TutorProfile' }"
                  >
                  <ProfileIcon />
                    Profile
                  </router-link>
                </li>

                <li>
                  <router-link
                  active-class="active-nav"
                    class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-white rounded-md hover:bg-white/10 dark:hover:bg-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-300 transition-colors duration-200"
                    :to="{ name: 'TutorSchedule' }"
                  >
                    <ScheduleIcon />
                    Schedule
                  </router-link>
                </li>

                <li>
                  <router-link
                  active-class="active-nav"
                    class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-white rounded-md hover:bg-white/10 dark:hover:bg-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-300 transition-colors duration-200"
                    :to="{ name: 'TutorRequests' }"
                  >
                    <RequestIcon />
                    Student requests
                  </router-link>
                </li>

                <li>
                  <router-link
                  active-class="active-nav"
                    class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-white rounded-md hover:bg-white/10 dark:hover:bg-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-300 transition-colors duration-200"
                    :to="{ name: 'TutorNotifications' }"
                  >
                    <NotificationIcon />
                    Notifications
                  </router-link>
                </li>
                <li>
                  <router-link
                  active-class="active-nav"
                    class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-white rounded-md hover:bg-white/10 dark:hover:bg-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-300 transition-colors duration-200"
                    :to="{ name: 'TutorSettings' }"
                  >
                    <SettingsIcon />
                    Settings
                  </router-link>
                </li>
              </ul>
            </div>

            <div v-else>
              <ul class="flex flex-col space-y-1">
                <li>
                  <router-link
                  active-class="active-nav"
                    class="flex items-center gap-x-3.5 py-2 px-2.5  text-sm text-white rounded-md hover:bg-white/10 focus:outline-none focus:bg-white/10 dark:bg-neutral-700 dark:text-white transition-colors duration-200"
                    :to="{ name: 'StudentHome' }"
                  >
                    <HomeIcon />
                    Home
                  </router-link>
                </li>

                <li>
                  <router-link
                  active-class="active-nav"
                    class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-white rounded-md hover:bg-white/10 dark:hover:bg-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-300 transition-colors duration-200"
                    :to="{ name: 'StudentProfile' }"
                  >
                    <ProfileIcon />
                    Profile
                  </router-link>
                </li>

                <li>
                  <router-link
                  active-class="active-nav"
                    class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-white rounded-md hover:bg-white/10 dark:hover:bg-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-300 transition-colors duration-200"
                    :to="{ name: 'StudentSchedule' }"
                  >
                    <ScheduleIcon />
                    Schedule
                  </router-link>
                </li>

                <li>
                  <router-link
                  active-class="active-nav"
                    class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-white rounded-md hover:bg-white/10 dark:hover:bg-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-300 transition-colors duration-200"
                    :to="{ name: 'StudentRequests' }"
                  >
                    <RequestIcon />
                    Your requests
                  </router-link>
                </li>

                <li>
                  <router-link
                  active-class="active-nav"
                    class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-white rounded-md hover:bg-white/10 dark:hover:bg-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-300 transition-colors duration-200"
                    :to="{ name: 'StudentNotifications' }"
                  >
                    <NotificationIcon />
                    Notifications
                  </router-link>
                </li>
              </ul>
            </div>

            <!-- Logout Section (Added at bottom) -->
            <div class="mt-auto">
              <hr class="my-4 border-white/20" />
              <!-- Profile Section with Placeholder -->
              <div class="flex  items-center gap-x-4 px-2.5 py-3">
                <!-- Placeholder Profile Image -->
                <div
                  class="rounded-full w-10 h-10 bg-white/10 flex items-center justify-center"
                >
                <!-- class="shrink-0 size-16 rounded-full" -->
                  <img
                  class="shrink-0 w-auto h-full rounded-full"
                    :src="userProfileImage || defaultProfileImage"
                    alt="profile image"
                  />
                </div>
                <!-- Placeholder Text -->
                <div class="flex flex-col">
                  <span class="text-sm font-medium text-white">{{
                    userFullName
                  }}</span>
                  <span class="text-xs text-white/70">{{ userEmail }}</span>
                </div>
              </div>
              <!-- Logout Button -->
              <button
                @click="logout"
                class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-white rounded-md hover:bg-white/10 dark:hover:bg-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-300 transition-colors duration-200"
              >
                <LogoutIcon />
                Logout
              </button>
            </div>
          </nav>
        </div>

        <!-- End Content -->
      </div>
    </div>
    <!-- End Sidebar -->

    <!-- Content -->
    <div
      class="w-full min-h-screen z-50 flex-wrap px-4 sm:px-6 md:px-8 lg:ps-72"
    >
      <slot></slot>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import axiosInstance from '@/axiosInstance'
import HomeIcon from '@/assets/HomeIcon.vue';
import NotificationIcon from '@/assets/NotificationIcon.vue';
import ProfileIcon from '@/assets/ProfileIcon.vue';
import RequestIcon from '@/assets/RequestIcon.vue';
import ScheduleIcon from '@/assets/ScheduleIcon.vue';
import LogoutIcon from '@/assets/LogoutIcon.vue';
import SettingsIcon from '@/assets/SettingsIcon.vue';

const defaultProfileImage =
  'data:image/svg+xml;base64,' +
  btoa(`
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
    <circle cx="12" cy="12" r="11" fill="white" stroke="#E5E7EB" stroke-width="2"/>
    <circle cx="12" cy="8" r="3.5" fill="#9CA3AF"/>
    <path d="M12 12.5c-3 0-5.5 1.5-7 3.5 1.5 3 4 5 7 5s5.5-2 7-5c-1.5-2-4-3.5-7-3.5z" fill="#9CA3AF"/>
  </svg>`)

const router = useRouter()

const userType = localStorage.getItem('user_type')
const userEmail = localStorage.getItem('user_email')
const userFullName = localStorage.getItem('user_full_name')


const getUserData = localStorage.getItem('user_data')
const userData = getUserData ? JSON.parse(getUserData) : null
const userProfileImage = userData ? userData.profile_image : null

async function logout() {
  try {
    console.log('logout is pressed')
    await axiosInstance.post('/api/logout')

    localStorage.removeItem('app_auth_token')
    localStorage.removeItem('user_type')
    localStorage.removeItem('user_email')
    localStorage.removeItem('user_data')
    localStorage.removeItem('user_full_name')

    delete axiosInstance.defaults.headers['Authorization']

    router.push({ name: 'Login' })
  } catch (error) {
    console.error('Logout failed:', error)
  }
}
</script>
<style>
.active-nav{
  background-color: rgba(255, 255, 255, 0.1);
}
</style>
