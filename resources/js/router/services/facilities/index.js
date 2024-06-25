export default [
    {
        path: "/facilities",
        name: "facilities.index",
        component: () => import("../../../views/facilities/IndexView.vue"),
        meta: {
            requiresAuth: false,
        },
    },
];
