import auth from "./services/auth";
import dashboard from "./services/dashboard";

const routes = [
    ...auth,
    ...dashboard,
    {
        path: "/",
        name: "home",
        component: () => import("../views/home/IndexView.vue"),
        meta: {
            requiresAuth: false,
        },
    },
];

export default routes;
