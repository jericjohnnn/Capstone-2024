<template>
  <div class="relative">
    <header class="w-full bg-blue-600 py-3">
      <nav class="mx-auto px-4 flex items-center justify-between">
        <!-- Brand -->
        <a class="text-xl font-semibold text-white" href="/">
          LOGO
        </a>

        <!-- Menu Items for Desktop -->
        <div class="hidden sm:flex sm:items-center">
          <a class="px-3 py-2 text-white hover:text-gray-200" href="/">About</a>
          <a class="px-3 py-2 text-white hover:text-gray-200" href="/">Services</a>
          <a class="px-3 py-2 text-white hover:text-gray-200" href="/">Contact</a>
        </div>

        <!-- Right side buttons -->
        <div class="flex items-center space-x-2">
          <!-- Mobile menu button -->
          <button type="button"
                  class="sm:hidden p-2 rounded-lg border border-white text-white hover:bg-blue-700"
                  @click="isMenuOpen = !isMenuOpen">
            <svg class="w-5 h-5"
                 xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
              <path v-if="!isMenuOpen" 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2" 
                    d="M4 6h16M4 12h16M4 18h16" />
              <path v-else 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2" 
                    d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>

          <!-- Desktop login/register buttons -->
          <div class="hidden sm:flex space-x-2">
            <a href="/login"
               class="px-3 py-2 text-sm font-medium rounded-lg border border-white text-white hover:bg-blue-700">
              Login
            </a>
            <a href="/register"
               class="px-3 py-2 text-sm font-medium rounded-lg bg-white text-blue-600 hover:bg-gray-100">
              Register
            </a>
          </div>
        </div>
      </nav>
    </header>

    <!-- Mobile Menu Dropdown -->
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="transform -translate-y-1 opacity-0"
      enter-to-class="transform translate-y-0 opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="transform translate-y-0 opacity-100"
      leave-to-class="transform -translate-y-1 opacity-0"
    >
      <div v-if="isMenuOpen" 
           class="sm:hidden absolute w-full bg-white shadow-lg">
        <div class="flex flex-col p-4">
          <a class="px-3 py-2 text-gray-800 hover:text-gray-600" href="/">About</a>
          <a class="px-3 py-2 text-gray-800 hover:text-gray-600" href="/">Services</a>
          <a class="px-3 py-2 text-gray-800 hover:text-gray-600" href="/">Contact</a>
          <div class="border-t border-gray-200 my-2"></div>
          <a class="px-3 py-2 text-gray-800 hover:text-gray-600" href="/login">Login</a>
          <a class="px-3 py-2 text-gray-800 hover:text-gray-600" href="/register">Register</a>
        </div>
      </div>
    </Transition>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const isMenuOpen = ref(false)
</script>
