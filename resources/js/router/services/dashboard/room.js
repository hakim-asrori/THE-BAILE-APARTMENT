import { CreateView, EditView, IndexView } from "../../../views/dashboard/room";

export default [
    {
        path: "/home/room",
        name: "home.room.index",
        component: IndexView,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/home/room/create",
        name: "home.room.create",
        component: CreateView,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/home/room/:id/edit",
        name: "home.room.edit",
        component: EditView,
        meta: {
            requiresAuth: true,
        },
        props: true,
    },
];
