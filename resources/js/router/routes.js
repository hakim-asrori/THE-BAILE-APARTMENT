import auth from "./services/auth";
import dashboard from "./services/dashboard";
import enquire from "./services/enquire";
import contact from "./services/contact";

const routes = [
    ...auth,
    ...dashboard,
    ...enquire,
    ...contact,
    {
        path: "/",
        name: "home",
        component: () => import("../views/home/IndexView.vue"),
    },
];

export default routes;
