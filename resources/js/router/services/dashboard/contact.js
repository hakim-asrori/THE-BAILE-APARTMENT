import { IndexView } from "../../../views/dashboard/contact";

export default [
    {
        path: "/home/contact",
        name: "home.contact.index",
        component: IndexView,
        meta: {
            requiresAuth: true,
        },
    },
];
