import axios from "axios";
import Cookies from "js-cookie";

const API_BASE_URL = "api/";

export const Api = axios.create({
    baseURL: API_BASE_URL,
    timeout: 60000,
    withCredentials: true,
});

Api.interceptors.request.use(
    async function (request) {
        request.headers = {
            ...request.headers,
            'Authorization': 'Bearer ' + Cookies.get('token'),
            'Accept': 'application/json',
        };

        const csrfToken = await getCsrfToken();
        if (csrfToken) {
            request.headers['X-XSRF-TOKEN'] = csrfToken;
        }
        return request;
    },
    function (error) {
        return Promise.reject(error);
    }
);

async function getCsrfToken() {
    const csrfCookie = document.cookie
        .split(";")
        .find(cookie => cookie.trim().startsWith("XSRF-TOKEN="));

    if (csrfCookie) {
        return csrfCookie.split("=")[1];
    }
    return null;
}
