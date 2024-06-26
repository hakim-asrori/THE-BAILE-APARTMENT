import { IndexView, CreateView } from "../../../views/dashboard/facility";

export default [
    {
        path: "/dashboard/facility",
        name: "facility.index",
        component: IndexView,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/dashboard/facility/create",
        name: "facility.create",
        component: CreateView,
        meta: {
            requiresAuth: true,
        },
    },
];
