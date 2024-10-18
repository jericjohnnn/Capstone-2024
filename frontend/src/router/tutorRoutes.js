import TutorProfilePage from "@/pages/tutor/TutorProfilePage.vue";
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
];

export default tutorRoutes;
