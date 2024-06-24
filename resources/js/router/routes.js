import auth from "./services/auth";
import dashboard from "./services/dashboard";
import enquire from "./services/enquire";

const routes = [
    ...auth,
    ...dashboard,
    ...enquire,
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
