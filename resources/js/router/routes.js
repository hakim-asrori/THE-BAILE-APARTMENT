import auth from "./services/auth";
import dashboard from "./services/dashboard";
import facility from "./services/dashboard/facility";
import contact from "./services/dashboard/contact";
import enquire from "./services/dashboard/enquire";
import gallery from "./services/dashboard/gallery";
import room from "./services/dashboard/room";

const routes = [
    ...auth,
    ...dashboard,
    ...facility,
    ...contact,
    ...enquire,
    ...gallery,
    ...room,
    {
        path: "/",
        name: "home",
        component: () => import("../views/home/IndexView.vue"),
    },
];

export default routes;
