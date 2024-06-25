export default [
    {
        path: "/room-type",
        name: "room-type.index",
        component: () => import("../../../views/room-type/IndexView.vue"),
        meta: {
            requiresAuth: false,
        },
    },
];
