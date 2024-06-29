import { IndexView } from "../../../views/dashboard/room";

export default [
    {
        path: "/home/room",
        name: "room.index",
        component: IndexView,
        meta: {
            requiresAuth: true,
        },
    },
];
