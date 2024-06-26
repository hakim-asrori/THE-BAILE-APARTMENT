export default [
    {
        path: "/home",
        name: "dashboard.index",
        component: () => import("../../../views/dashboard/home/IndexView.vue"),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/home/contact/test",
        name: "home.contact.test",
        component: () => import("../../../views/dashboard/home/IndexView.vue"),
        meta: {
            requiresAuth: true,
        },
    },
];
