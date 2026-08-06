import { createRouter, createWebHistory } from 'vue-router';
import axios from 'axios';

const routes = [
    // Frontend Routes
    {
        path: '/',
        component: () => import('@/frontend/layouts/FrontendLayout.vue'),
        children: [
            {
                path: '',
                name: 'home',
                component: () => import('@/frontend/pages/Home.vue'),
            },
            {
                path: 'jobs',
                name: 'jobs',
                component: () => import('@/frontend/pages/Jobs.vue'),
            },
            {
                path: 'jobs/:id',
                name: 'job-details',
                component: () => import('@/frontend/pages/JobDetails.vue'),
            }
        ],
    },
    // Admin Routes
    {
        path: '/admin',
        component: () => import('@/admin/layouts/AdminLayout.vue'),
        meta: { requiresAuth: true },
        children: [
            {
                path: '',
                name: 'admin.dashboard',
                component: () => import('@/admin/pages/Dashboard.vue'),
            },
            {
                path: 'categories',
                name: 'admin.categories',
                component: () => import('@/admin/pages/JobCategories.vue'),
            },
            {
                path: 'clients',
                name: 'admin.clients',
                component: () => import('@/admin/pages/Clients.vue'),
            },
            {
                path: 'jobs',
                name: 'admin.jobs',
                component: () => import('@/admin/pages/Jobs.vue'),
            },
            {
                path: 'applications',
                name: 'admin.applications',
                component: () => import('@/admin/pages/JobApplications.vue'),
            }
        ]
    },
    {
        path: '/admin/login',
        name: 'admin.login',
        component: () => import('@/admin/pages/Login.vue'),
        meta: { guest: true }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Guard
router.beforeEach(async (to, from, next) => {
    const isAuthRequired = to.matched.some(record => record.meta.requiresAuth);
    const isGuestOnly = to.matched.some(record => record.meta.guest);

    if (isAuthRequired || isGuestOnly) {
        try {
            await axios.get('/user');
            // Logged in
            if (isGuestOnly) {
                next({ name: 'admin.dashboard' });
            } else {
                next();
            }
        } catch (error) {
            // Not logged in
            if (isAuthRequired) {
                next({ name: 'admin.login' });
            } else {
                next();
            }
        }
    } else {
        next();
    }
});

export default router;
