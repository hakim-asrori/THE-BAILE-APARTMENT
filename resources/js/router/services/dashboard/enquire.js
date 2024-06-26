import { IndexView } from "../../../views/dashboard/enquire";

export default [
    {
        path: "/dashboard/enquire",
        name: "enquire.index",
        component: IndexView,
        meta: {
            requiresAuth: true,
        },
    },
];
