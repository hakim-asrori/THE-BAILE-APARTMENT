import { IndexView, CreateView, EditView } from "../../../views/dashboard/facility";

export default [
    {
        path: "/home/facility",
        name: "home.facility.index",
        component: IndexView,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/home/facility/create",
        name: "home.facility.create",
        component: CreateView,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/home/facility/:id/edit",
        name: "home.facility.edit",
        component: EditView,
        meta: {
            requiresAuth: true,
        },
        props: true
    },
];
