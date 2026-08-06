import { createRouter, createWebHistory } from 'vue-router';
import axios from 'axios';

const routes = [
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
                path: 'industry-types',
                name: 'admin.industry-types',
                component: () => import('@/admin/pages/IndustryTypes.vue'),
            },
            {
                path: 'job-types',
                name: 'admin.job-types',
                component: () => import('@/admin/pages/JobTypes.vue'),
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
            },
            {
                path: 'skills',
                name: 'admin.skills',
                component: () => import('@/admin/pages/Skills.vue'),
            },
            {
                path: 'currencies',
                name: 'admin.currencies',
                component: () => import('@/admin/pages/Currencies.vue'),
            },
            {
                path: 'roles',
                name: 'admin.roles',
                component: () => import('@/admin/pages/Roles.vue'),
            },
            {
                path: 'users',
                name: 'admin.users',
                component: () => import('@/admin/pages/Users.vue'),
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

import { useAuth } from '@/admin/composables/useAuth';

// Guard
router.beforeEach(async (to, from, next) => {
    const { initAuth } = useAuth();

    const isAuthRequired = to.matched.some(record => record.meta.requiresAuth);
    const isGuestOnly = to.matched.some(record => record.meta.guest);

    if (isAuthRequired || isGuestOnly) {
        try {
            await initAuth(); // This fetches /user and populates permissions
            const { user } = useAuth();

            if (user.value) {
                // Logged in
                if (isGuestOnly) {
                    next({ name: 'admin.dashboard' });
                } else {
                    next();
                }
            } else {
                throw new Error('Not authenticated');
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
