import { ref, computed } from 'vue';
import axios from '@/admin/utils/axios';

const user = ref(null);
const roles = ref([]);
const permissions = ref([]);
const isInitialized = ref(false);
let initPromise = null;

export const useAuth = () => {
    const initAuth = async () => {
        if (isInitialized.value) return;
        if (initPromise) return initPromise;

        initPromise = (async () => {
            try {
                const res = await axios.get('/user');
                user.value = res.data.user;
                roles.value = res.data.roles || [];
                permissions.value = res.data.permissions || [];
            } catch (e) {
                user.value = null;
                roles.value = [];
                permissions.value = [];
                console.error('Auth initialization failed:', e.response?.status, e.message);
            } finally {
                isInitialized.value = true;
                initPromise = null;
            }
        })();

        return initPromise;
    };

    const hasPermission = (permissionName) => {
        if (roles.value.includes('super-admin')) return true;
        return permissions.value.includes(permissionName);
    };

    return {
        user,
        roles,
        permissions,
        isInitialized,
        initAuth,
        hasPermission,
    };
};
