import './bootstrap';

import { createApp } from 'vue'
import { AppCore } from './core';

// import dotenv from 'dotenv';
// dotenv.config();
import router from './router';
import store from './store';

createApp(AppCore).use(store).use(router).mount("#app")
