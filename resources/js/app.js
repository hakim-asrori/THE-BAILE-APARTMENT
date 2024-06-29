import "./bootstrap";

import { createApp } from "vue";
import { AppCore, DashboardCore, AuthCore } from "./core";
import ToastPlugin from 'vue-toast-notification';
import "vue-toast-notification/dist/theme-sugar.css";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

// import dotenv from 'dotenv';
// dotenv.config();
import router from "./router";
import store from "./store";

createApp(AppCore).use(store).use(router).mount("#app");
createApp(DashboardCore).use(store).use(router).use(ToastPlugin).use(VueSweetalert2).mount("#dashboard");
createApp(AuthCore).use(store).use(router).use(ToastPlugin).use(VueSweetalert2).mount("#auth");
