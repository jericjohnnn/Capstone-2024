<template>
  <main class="bg-blue-50">
    <SideBar>
      <main class="container flex flex-col gap-14 min-h-screen ">
        <SentRequestsTabs>
          <template #all>
            <AllSentRequestsCard />
          </template>
          <template #pending>
            <PendingSentRequestsCard />
          </template>
          <template #completed>
            <CompletedSentRequestsCard />
          </template>
        </SentRequestsTabs>
      </main>
    </SideBar>
    <!-- <HelpButton /> -->
  </main>
</template>
<script setup>
import SideBar from '@/components/SideBar.vue'
import AllSentRequestsCard from '@/components/StudentSentRequests/AllSentRequestsCard.vue';
import CompletedSentRequestsCard from '@/components/StudentSentRequests/CompletedSentRequestsCard.vue';
import PendingSentRequestsCard from '@/components/StudentSentRequests/PendingSentRequestsCard.vue';
import SentRequestsTabs from '@/components/StudentSentRequests/SentRequestsTabs.vue';
// import HelpButton from '@/components/HelpButton.vue'

</script>
