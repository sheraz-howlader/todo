import {Api} from "./AxiosInstance";

export default {
    get(url) {
        return Api.get(`${url}`);
    },

    save(url, data) {
        return Api.post(`${url}`, data);
    },

    edit(url, ID) {
        return Api.get(`${url}/${ID}/edit`);
    },

    update(url, data) {
        return Api.put(`${url}/${data.task_id}/`, data)
    },

    delete(url, ID) {
        return Api.delete(`${url}/${ID}`);
    },
}
