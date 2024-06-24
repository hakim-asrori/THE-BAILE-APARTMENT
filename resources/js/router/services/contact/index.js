export default [
    {
        path: "/contact",
        name: "contact.index",
        component: () => import("../../../views/contact/IndexView.vue"),
        meta: {
            requiresAuth: false,
        },
    },
];
