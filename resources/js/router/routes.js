import auth from "./services/auth";
import dashboard from "./services/dashboard";
import facility from "./services/dashboard/facility";
import contact from "./services/dashboard/contact";
import enquire from "./services/dashboard/enquire";
import gallery from "./services/dashboard/gallery";
import room from "./services/dashboard/room";
import facilitesLanding from "./services/facilities";
import roomTypeLanding from "./services/room-type";
import galleryLanding from "./services/gallery";
import contactLanding from "./services/contact";
import enquireLanding from "./services/enquire";

const routes = [
    ...auth,
    ...dashboard,
    ...facility,
    ...contact,
    ...enquire,
    ...gallery,
    ...room,
    ...facilitesLanding,
    ...roomTypeLanding,
    ...galleryLanding,
    ...enquireLanding,
    ...contactLanding,
    {
        path: "/",
        name: "home",
        component: () => import("../views/home/IndexView.vue"),
    },
];

export default routes;
