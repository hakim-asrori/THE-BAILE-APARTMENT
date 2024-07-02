import { IndexView, CreateView } from "../../../views/dashboard/facility";

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
];
