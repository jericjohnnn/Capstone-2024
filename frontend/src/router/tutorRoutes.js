import TutorNotificationPage from "@/pages/tutor/TutorNotificationPage.vue";
import TutorProfilePage from "@/pages/tutor/TutorProfilePage.vue";
import TutorBookDetailsPage from "@/pages/tutor/TutorBookDetailsPage.vue";
import TutorReceivedRequestsPage from "@/pages/tutor/TutorReceivedRequestsPage.vue";
import TutorSchedulePage from "@/pages/tutor/TutorSchedulePage.vue";
import TutorSettingsPage from "@/pages/tutor/TutorSettingsPage.vue";


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
    path: '/tutor/requests/:bookId',
    name: 'TutorBookDetails',
    component: TutorBookDetailsPage
  },
  {
    path: '/tutor/notifications',
    name: 'TutorNotifications',
    component: TutorNotificationPage
  },
  {
    path: '/tutor/settings',
    name: 'TutorSettings',
    component: TutorSettingsPage
  },
];

export default tutorRoutes;
