import { IndexView } from "../../../views/dashboard/gallery";

export default [
    {
        path: "/home/gallery",
        name: "home.gallery.index",
        component: IndexView,
        meta: {
            requiresAuth: true,
        },
    },
];
