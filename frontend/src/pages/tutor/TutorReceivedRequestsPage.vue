<template>
  <main class="bg-blue-50">
    <SideBar>
      <main class="container flex flex-col gap-14 min-h-screen ">
        <!-- Breadcrumb -->
        <BreadCrumb
          :breadcrumbs="[
            { label: 'Requests', route: '/tutor/requests' },
          ]"
        />
        <RequestsTabs>
          <template #pending>
            <PendingRequestsCard />
          </template>
          <template #completed>
            <CompletedRequestsCard />
          </template>
        </RequestsTabs>
      </main>
    </SideBar>
    <!-- <HelpButton /> -->
  </main>
</template>
<script setup>
import BreadCrumb from '@/components/BreadCrumb.vue'
import SideBar from '@/components/SideBar.vue'
import RequestsTabs from '@/components/TutorReceivedRequests/RequestsTabs.vue'
// import HelpButton from '@/components/HelpButton.vue'
import PendingRequestsCard from '@/components/TutorReceivedRequests/PendingRequestsCard.vue'
import CompletedRequestsCard from '@/components/TutorReceivedRequests/CompletedRequestsCard.vue'
</script>
