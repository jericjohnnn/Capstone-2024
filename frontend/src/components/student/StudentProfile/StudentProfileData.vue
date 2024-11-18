<template>
  <div class="w-full border font-normal bg-gray-200 text-gray-600 border-neutral-400 rounded mt-4">
    <div class="px-7 py-4 border-b text-gray-700 font-semibold">Profile and Other Data</div>

    <!-- Profile Image -->
    <div class="grid grid-cols-2 gap-4 py-4 px-7 border-b text-xs items-center">
      Profile Image
      <img v-if="userData" :src="userData.profile_image" alt="Profile Image" class="w-12 h-12 object-cover rounded-full border border-gray-400 shadow-md" />
    </div>

    <!-- Other Data -->
    <div class="grid grid-cols-2 gap-4 py-4 px-7 border-b text-xs items-center">
      Birthdate
      <span class="font-semibold text-black">{{ userData?.birthdate }}</span>
    </div>

    <div class="grid grid-cols-2 gap-4 px-7 py-4 border-b text-xs items-center">
      School Id Number
      <span class="font-semibold text-black">{{ userData?.school_id_number }}</span>
    </div>

    <div class="grid grid-cols-2 gap-4 px-7 py-4 border-b text-xs items-center">
      Grade Level
      <span class="font-semibold text-black">{{ userData?.grade_year }}</span>
    </div>
  </div>
</template>

<script setup>
defineProps({
  userData: Object
})
</script>
