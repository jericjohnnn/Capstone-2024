<template>
    <div class="flex flex-row">
        <SideBar/>
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
                        <div class="flex-1 text-center">Role</div>
                        <div class="flex-1 text-center">Reported By</div>
                        <div class="flex-1 text-center">Reason</div>
                        <div class="flex-1 text-center">Actions</div>
                    </div>
                    <!-- Sample Data Row (You can replace this with actual data) -->
                    <div class="flex text-gray-600 py-2">
                        <div class="flex text-center">1</div>
                        <div class="flex-1 text-center">John Doe</div>
                        <div class="flex-1 text-center">123 Main St</div>
                        <div class="flex-1 text-center">123-456-7890</div>
                        <div class="flex-1 text-center">Tutor</div>
                        <div class="flex-1 text-center">Jeric John Aligato</div>
                        <div class="flex-1 text-center">Gwapo kaayo siya mo tudlo hehe magbasa akong lubot</div>
                        <div class="flex-1 text-center">
                        <div class="flex-1 text-center">
                        <div class="flex flex-col items-center">
                            <button class="bg-red-300 text-white px-2 py-1 rounded hover:bg-red-400 mb-1">Warning</button>
                            <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 mb-1">Penalty</button>
                            <button class="bg-red-800 text-white px-2 py-1 rounded hover:bg-red-950">Banned</button>
                        </div>
                        </div>

                        </div>
                    </div>

                    <div class="flex text-gray-600 py-2">
                        <div class="flex text-center">2</div>
                        <div class="flex-1 text-center">Jane Smith</div>
                        <div class="flex-1 text-center">456 Oak St</div>
                        <div class="flex-1 text-center">987-654-3210</div>
                        <div class="flex-1 text-center">Student</div>
                        <div class="flex-1 text-center">Mark Santos</div>
                        <div class="flex-1 text-center">She needs help with math.</div>
                        <div class="flex-1 text-center">
                        <div class="flex flex-col items-center">
                            <button class="bg-red-300 text-white px-2 py-1 rounded hover:bg-red-400 mb-1">Warning</button>
                            <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 mb-1">Penalty</button>
                            <button class="bg-red-800 text-white px-2 py-1 rounded hover:bg-red-950">Banned</button>
                        </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import SideBar from './SideBar.vue';
</script>
