export default [
    {
        path: "/gallery",
        name: "gallery.index",
        component: () => import("../../../views/gallery/IndexView.vue"),
        meta: {
            requiresAuth: false,
        },
    },
];
