import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from "pinia";

import App from './components/App.vue';
import router from "./router";

const pinia = createPinia();

createApp(App)
    .use(router)
    .use(pinia)
    .mount('#app');
