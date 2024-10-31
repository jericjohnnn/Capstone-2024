import StudentHomePage from "@/pages/student/StudentHomePage.vue";
import StudentBookTutorPage from "@/pages/student/StudentBookTutorPage.vue";
import StudentSchedulePage from "@/pages/student/StudentSchedulePage.vue";
import StudentSentRequestsPage from "@/pages/student/StudentSentRequestsPage.vue";
import StudentNotificationPage from "@/pages/student/StudentNotificationPage.vue";

const studentRoutes = [
  {
    path: '/student/home',
    name: 'StudentHome',
    component: StudentHomePage
  },
  {
    path: '/student/schedule',
    name: 'StudentSchedule',
    component: StudentSchedulePage
  },
  {
    path: '/student/requests',
    name: 'StudentRequests',
    component: StudentSentRequestsPage
  },
  {
    path: '/student/notifications',
    name: 'StudentNotifications',
    component: StudentNotificationPage
  },
  {
    path: '/student/book/:tutorId',
    name: 'StudentBook',
    component: StudentBookTutorPage
  },
];

export default studentRoutes;
