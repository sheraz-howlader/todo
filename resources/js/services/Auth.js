import {Api} from "./AxiosInstance";

export default {
    login(url, data) {
        return Api.post(`${url}`, data);
    },

    logOut(url) {
        return Api.delete(`${url}`);
    },
}
