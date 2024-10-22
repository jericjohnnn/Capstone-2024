<template>
    <div class="flex flex-row">
        <AdminPage/>
    <div class="flex flex-col">
    <div class="ml-6 flex-grow">
      <div class="flex items-center py-8">
        <p class="text-4xl font-bold">Users Dashboard</p>
        
        <div class="flex items-center ml-[279px]">
          <!-- Search Input -->
          <input
            type="text"
            placeholder="Search users..."
            class="px-4 py-2 border border-gray-300 rounded-lg w-[350px] focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <img 
            src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9ImN1cnJlbnRDb2xvciIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiIGNsYXNzPSJsdWNpZGUgbHVjaWRlLWJlbGwiPjxwYXRoIGQ9Ik02IDhhNiA2IDAgMCAxIDEyIDBjMCA3IDMgOSAzIDlIM3MzLTIgMy05Ii8+PHBhdGggZD0iTTEwLjMgMjFhMS45NCAxLjk0IDAgMCAwIDMuNCAwIi8+PC9zdmc+" 
            alt="Bell Icon" 
            class="ml-5 w-6 h-6"
          />
          <div class="ml-5 w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
            <span class="text-white font-bold">P</span> <!-- Placeholder text or icon -->
          </div>
        </div>
      </div>
      <div class="flex flex-col">
        <!-- Header Row with 8 Columns -->
        <div class="flex text-lg font-bold text-gray-700 border-b pb-2">
          <div class="flex text-center">ID</div>
          <div class="flex-1 text-center">Name</div>
          <div class="flex-1 text-center">Address</div>
          <div class="flex-1 text-center">Contact #</div>
          <div class="flex-1 text-center">Course and Year Level</div>
          <div class="flex-1 text-center">Subjects to Handle</div>
          <div class="flex-1 text-center">Student Tutored</div>
          <div class="flex-1 text-center">Reports</div>
        </div>
        <!-- Sample Data Row (You can replace this with actual data) -->
        <div class="flex text-gray-600 py-2">
          <div class="flex text-center">1</div>
          <div class="flex-1 text-center">John Doe</div>
          <div class="flex-1 text-center">123 Main St</div>
          <div class="flex-1 text-center">123-456-7890</div>
          <div class="flex-1 text-center">BSIT_4</div>
          <div class="flex-1 text-center">Calculus, Algebra</div>
          <div class="flex-1 text-center">6</div>
          <div class="flex-1 text-center">0</div>
        </div>

        <div class="flex text-gray-600 py-2">
          <div class="flex text-center">1</div>
          <div class="flex-1 text-center">John Doe</div>
          <div class="flex-1 text-center">123 Main St</div>
          <div class="flex-1 text-center">123-456-7890</div>
          <div class="flex-1 text-center">BSIT_4</div>
          <div class="flex-1 text-center">Calculus, Algebra</div>
          <div class="flex-1 text-center">3</div>
          <div class="flex-1 text-center">1</div>
        </div>
      </div>
    </div>
    
    </div>
    </div>
</template>
<script setup>
import AdminPage from '@/pages/admin/AdminPage.vue';
</script>