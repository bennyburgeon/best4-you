import { createApp } from 'vue';
import router from './router';
import App from './App.vue';
import axios from 'axios';

axios.defaults.baseURL = '/api';
axios.defaults.withCredentials = true;

const app = createApp(App);
app.config.globalProperties.$axios = axios;
app.use(router);
app.mount('#app');
