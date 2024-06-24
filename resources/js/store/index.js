import { createStore } from "vuex";
import action from "./services/action";

const store = createStore({
    modules: {
        action,
    },
    state: {
        STATUS_CODE: {
            NOT_FOUND: 404,
            OK: 200,
            CREATED: 201,
            SERVER_ERROR: 500,
            BAD_REQUEST: 400,
            VALIDATION: 422,
        },
        user: null,
    },
});

export default store;
