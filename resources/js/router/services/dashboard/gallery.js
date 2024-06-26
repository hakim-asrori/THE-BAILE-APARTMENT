import { IndexView } from "../../../views/dashboard/gallery";

export default [
    {
        path: "/dashboard/gallery",
        name: "gallery.index",
        component: IndexView,
        meta: {
            requiresAuth: true,
        },
    },
];
