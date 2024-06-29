import { IndexView } from "../../../views/dashboard/contact";

export default [
    {
        path: "/home/contact",
        name: "contact.index",
        component: IndexView,
        meta: {
            requiresAuth: true,
        },
    },
];
