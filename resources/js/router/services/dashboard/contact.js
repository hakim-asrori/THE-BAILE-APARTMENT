import { IndexView } from "../../../views/dashboard/contact";

export default [
    {
        path: "/dashboard/contact",
        name: "contact.index",
        component: IndexView,
        meta: {
            requiresAuth: true,
        },
    },
];
