<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Navbar -->
   <NavBar />
   <HeroSection />
   <TeamSection />
   <FeaturesSection />
   <SubscribeSection />
  <FooterSection />
  </div>
</template>

<script setup>
import HeroSection from '../sections/HeroSection.vue';
import NavBar from '../sections/NavBar.vue';
import FooterSection from '../sections/FooterSection.vue';
import TeamSection from '../sections/TeamSection.vue';
import FeaturesSection from '../sections/FeaturesSection.vue';
import SubscribeSection from '../sections/SubscribeSection.vue';

</script>

<style scoped>

</style>
