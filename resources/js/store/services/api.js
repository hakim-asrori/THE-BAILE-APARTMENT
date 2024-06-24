import axios from "axios";
import camelcaseKeys from "camelcase-keys";
import Cookies from "js-cookie";
import snakecaseKeys from "snakecase-keys";
import bcryptjs from "bcryptjs";

const api = {
    init() {
        axios.defaults.baseURL = "/api/v1/";
        axios.defaults.headers.post["Content-Type"] = "multipart/form-data";
        axios.defaults.headers.common.Authorization =
            "Bearer " + Cookies.get("baile");
        axios.defaults.headers.common["X-Baile-Token"] = bcryptjs.hashSync(
            import.meta.env.VITE_TOKEN,
            bcryptjs.genSaltSync(10)
        );
    },
    post(resource, params) {
        return axios.post(`${resource}`, params, {
            transformResponse: [
                (data) => {
                    if (data) {
                        return camelcaseKeys(JSON.parse(data), { deep: true });
                    }
                },
            ],
        });
    },
};

export default api;
