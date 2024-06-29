import { IndexView, CreateView } from "../../../views/dashboard/facility";

export default [
    {
        path: "/home/facility",
        name: "facility.index",
        component: IndexView,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/home/facility/create",
        name: "facility.create",
        component: CreateView,
        meta: {
            requiresAuth: true,
        },
    },
];
