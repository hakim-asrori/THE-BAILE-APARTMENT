import "./bootstrap";

import { createApp } from "vue";
import { AppCore, DashboardCore, AuthCore } from "./core";

// import dotenv from 'dotenv';
// dotenv.config();
import router from "./router";
import store from "./store";

createApp(AppCore).use(store).use(router).mount("#app");
createApp(DashboardCore).use(store).use(router).mount("#dashboard");
createApp(AuthCore).use(store).use(router).mount("#auth");
