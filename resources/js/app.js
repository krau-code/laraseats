// require('./bootstrap');

import { createApp } from 'vue/dist/vue.esm-bundler';
import router from './router/index.js';

createApp().use(router).mount('#app');
