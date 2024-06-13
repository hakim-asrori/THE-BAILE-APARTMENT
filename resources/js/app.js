import './bootstrap';

import { createApp } from 'vue'
import { AppCore } from './core';

import router from './router';
import store from './store';

createApp(AppCore).use(store).use(router).mount("#app")
