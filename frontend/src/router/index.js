import { createRouter, createWebHistory } from 'vue-router';
import LandingPage from '@/pages/LandingPage.vue';


const routes = [
  {
    path: '/',
    name: 'Main',
    component: LandingPage
  },
  // {
  //   path: '/login',
  //   name: 'Login',
  //   component: LoginPage
  // },
  // {
  //   path: '/register',
  //   name: 'Register',
  //   component: RegisterPage
  // },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
