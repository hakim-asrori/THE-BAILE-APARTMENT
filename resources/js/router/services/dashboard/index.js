export default [
    {
        path: "/dashboard/index",
        name: "dashboard.index",
        component: () => import("../../../views/dashboard/home/IndexView.vue"),
        meta: {
            requiresAuth: true,
        },
    },
];
