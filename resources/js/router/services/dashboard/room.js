import { IndexView } from "../../../views/dashboard/room";

export default [
    {
        path: "/dashboard/room",
        name: "room.index",
        component: IndexView,
        meta: {
            requiresAuth: true,
        },
    },
];
