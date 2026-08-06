import { createApp } from 'vue';
import App from '@/admin/App.vue';
import axios from '@/admin/utils/axios';
import router from '@/admin/router';
import { registerPlugins } from '@/admin/@core/utils/plugins';

// Styles
import '@/admin/@core/scss/template/index.scss';
import '@layouts/styles/index.scss';
import '@styles/styles.scss';

const app = createApp(App);

app.config.globalProperties.$axios = axios;

// Register plugins (Vuetify, Pinia, etc.)
registerPlugins(app);

// Must install router separately because it's distinct from the plugins
app.use(router);

app.mount('#app');
