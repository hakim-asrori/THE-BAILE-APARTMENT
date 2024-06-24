export default [
    {
        path: "/enquire",
        name: "enquire.index",
        component: () => import("../../../views/enquire/IndexView.vue"),
        meta: {
            requiresAuth: false,
        },
    },
];
