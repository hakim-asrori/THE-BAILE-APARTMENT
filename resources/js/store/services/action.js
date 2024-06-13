import api from "./api";

const action = {
    actions: {
        postData(context, param) {
            return new Promise((resolve, reject) => {
                api.init();
                api.post(param[0], param[1]).then(
                    (response) => {
                        resolve(response.data);
                    },
                    (error) => {
                        reject(error);
                    }
                );
            });
        },
    },
};

export default action;
