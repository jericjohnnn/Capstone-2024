import ActiveStudents from '@/components/ActiveStudents.vue'
import ActiveTutors from '@/components/ActiveTutors.vue'
import TutorApplication from '@/components/TutorApplication.vue'
import UsersReport from '@/components/UsersReport.vue'
import AdminPage from '@/pages/admin/AdminPage.vue'

const adminRoutes = [
  {
    path: '/',
    name: 'Main',
    component: AdminPage,
  },
  {
    path: '/admin/tutorApplication',
    name: 'TutorApplication',
    component: TutorApplication,
  },
  {
    path: '/admin/activeTutors',
    name: 'ActiveTutors',
    component: ActiveTutors,
  },
  {
    path: '/admin/activeStudents',
    name: 'ActiveStudents',
    component: ActiveStudents,
  },
  {
    path: '/admin/reports',
    name: 'UsersReport',
    component: UsersReport,
  },
  
]

export default adminRoutes
