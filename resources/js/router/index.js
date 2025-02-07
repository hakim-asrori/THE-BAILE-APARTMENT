import { createRouter, createWebHistory } from "vue-router";
import routes from "./routes";
import Cookies from "js-cookie";

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: "mm-active",
});

router.beforeEach((to, form, next) => {
    const token = Cookies.get("baile");

    if (to.meta.requiresAuth == true) {
        if (!token) {
            window.location.replace("/sign");
        } else {
            next();
        }
    }

    // if (to.meta.requiresAuth == false) {
    //     if (token) {
    //         window.location.replace("/home");
    //     } else {
    //         next();
    //     }
    // }

    next();
});

export default router;
