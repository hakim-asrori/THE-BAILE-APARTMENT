import { IndexView } from "../../../views/dashboard/gallery";

export default [
    {
        path: "/home/gallery",
        name: "gallery.index",
        component: IndexView,
        meta: {
            requiresAuth: true,
        },
    },
];
