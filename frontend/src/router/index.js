import { createRouter, createWebHistory } from 'vue-router';
import authRoutes from './authRoutes';
import tutorRoutes from './tutorRoutes';
import studentRoutes from './studentRoutes';

const router = createRouter({
  history: createWebHistory(),
  routes: [...authRoutes, ...tutorRoutes, ...studentRoutes],
});

export default router;
