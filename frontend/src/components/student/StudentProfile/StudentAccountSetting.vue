<template>
  <div class="w-full border font-normal bg-gray-200 border-neutral-400 rounded mt-4">
    <div class="px-7 py-4 border-b text-gray-700 font-semibold">Account</div>

    <!-- Delete Account Section -->
    <div class="flex-row flex py-4 px-7 border-b justify-between">
      <div class="flex-col flex text-sm font-semibold">Delete Account
        <span class="font-normal text-xs text-gray-600">
          This action is irreversible, and all your data will be lost.
        </span>
      </div>
      <button @click="$emit('delete')" class="px-5 text-xs rounded-md font-normal bg-red-500 text-white py-2">Delete Account</button>
    </div>
  </div>
</template>

<script setup>
defineProps({
  userData: Object
})
</script>
