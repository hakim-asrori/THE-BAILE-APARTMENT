import auth from "./services/auth";
import dashboard from "./services/dashboard";
import enquire from "./services/enquire";
import contact from "./services/contact";
import gallery from "./services/gallery";
import facilities from "./services/facilities";

const routes = [
    ...auth,
    ...dashboard,
    ...enquire,
    ...contact,
    ...gallery,
    ...facilities,
    {
        path: "/",
        name: "home",
        component: () => import("../views/home/IndexView.vue"),
    },
];

export default routes;
