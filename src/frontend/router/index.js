import { createRouter, createWebHistory } from 'vue-router';
import Home from '../pages/Home.vue';
import Jobs from '../pages/Jobs.vue';
import JobDetails from '../pages/JobDetails.vue';
import Contact from '../pages/Contact.vue';
import About from '../pages/About.vue';
import Services from '../pages/Services.vue';
import UploadResume from '../pages/UploadResume.vue';
import FrontendLayout from '../layouts/FrontendLayout.vue';

const routes = [
    {
        path: '/',
        component: FrontendLayout,
        children: [
            {
                path: '',
                name: 'home',
                component: Home,
            },
            {
                path: 'jobs',
                name: 'jobs',
                component: Jobs,
            },
            {
                path: 'jobs/:id',
                name: 'job-details',
                component: JobDetails,
            },
            {
                path: 'contact',
                name: 'contact',
                component: Contact,
            },
            {
                path: 'about',
                name: 'about',
                component: About,
            },
            {
                path: 'services',
                name: 'services',
                component: Services,
            },
            {
                path: 'upload-resume',
                name: 'upload-resume',
                component: UploadResume,
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior() {
        return { top: 0 };
    },
});

export default router;
