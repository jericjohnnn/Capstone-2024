import { createRouter, createWebHistory } from 'vue-router'
import authRoutes from './authRoutes'
import tutorRoutes from './tutorRoutes'
import studentRoutes from './studentRoutes'
import NotFoundPage from '@/pages/NotFoundPage.vue'

function isAuthenticated() {
  return !!localStorage.getItem('app_auth_token')
}

function getUserType() {
  return localStorage.getItem('user_type')
}

const router = createRouter({
  history: createWebHistory(),
  routes: [
    ...authRoutes,
    ...tutorRoutes,
    ...studentRoutes,
    {
      path: '/:catchAll(.*)', // Catch all unmatched routes
      name: 'NotFound',
      component: NotFoundPage,
    },
  ],
})

router.beforeEach((to, from, next) => {
  const publicPages = [
    'Main',
    'Login',
    'Register',
    'TutorRegister',
    'StudentRegister',
  ]
  const authPages = ['Login', 'Register', 'TutorRegister', 'StudentRegister']
  const authRequired = !publicPages.includes(to.name)
  const userType = getUserType()

  if (authRequired && !isAuthenticated()) {
    return next('/login')
  }

  if (isAuthenticated()) {
    if (authPages.includes(to.name)) {
      if (userType === 'student') {
        return next('/student/home')
      } else if (userType === 'tutor') {
        return next('/tutor/profile')
      }
    }

    if (to.path === '/tutor/' || to.path === '/tutor') {
      return next('/tutor/profile')
    }
    if (to.path === '/student/' || to.path === '/student') {
      return next('/student/home')
    }

    if (userType === 'student' && to.path.startsWith('/tutor')) {
      return next('/student/home')
    } else if (userType === 'tutor' && to.path.startsWith('/student')) {
      return next('/tutor/profile')
    }
  }
  next()
})

export default router
