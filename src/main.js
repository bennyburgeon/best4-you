import { createApp } from 'vue';
import router from './router';
import App from './App.vue';
import axios from 'axios';

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'

axios.defaults.baseURL = '/api';
axios.defaults.withCredentials = true;

const vuetify = createVuetify({
    components,
    directives,
})

const app = createApp(App);
app.config.globalProperties.$axios = axios;
app.use(router);
app.use(vuetify);
app.mount('#app');
