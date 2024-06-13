import auth from "./services/auth";

const routes = [
    ...auth,
    {
        path: "/",
        name: "home",
        component: () => import("../views/home/IndexView.vue"),
        meta: {
            requiresAuth: true,
        },
    },
]

export default routes;
