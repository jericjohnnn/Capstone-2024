import TutorNotificationPage from "@/pages/tutor/TutorNotificationPage.vue";
import TutorProfilePage from "@/pages/tutor/TutorProfilePage.vue";
import TutorReceivedRequestsPage from "@/pages/tutor/TutorReceivedRequestsPage.vue";
import TutorSchedulePage from "@/pages/tutor/TutorSchedulePage.vue";


const tutorRoutes = [
  {
    path: '/tutor/profile',
    name: 'TutorProfile',
    component: TutorProfilePage
  },
  {
    path: '/tutor/schedule',
    name: 'TutorSchedule',
    component: TutorSchedulePage
  },
  {
    path: '/tutor/requests',
    name: 'TutorRequests',
    component: TutorReceivedRequestsPage
  },
  {
    path: '/tutor/notifications',
    name: 'TutorNotifications',
    component: TutorNotificationPage
  },
];

export default tutorRoutes;
