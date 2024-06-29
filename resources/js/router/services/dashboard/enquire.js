import { IndexView } from "../../../views/dashboard/enquire";

export default [
    {
        path: "/home/enquire",
        name: "enquire.index",
        component: IndexView,
        meta: {
            requiresAuth: true,
        },
    },
];
