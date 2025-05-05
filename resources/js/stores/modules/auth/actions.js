import Auth from "../../../services/Auth.js";
import {AuthStore} from "@/stores/modules/auth";
import Cookies from "js-cookie";
import router from "../../../router/index.js";

export default {
    login (form_data) {
        Auth.login("/login", form_data)
            .then((response) => {
                if (response.data.success){
                    AuthStore().hasToken = response.data.token;
                    AuthStore().user =  response.data.user;

                    Cookies.set("token", response.data.token, {
                        sameSite: "lax",
                        secure: true,
                    });

                    router.push({name: 'todo'}).then(() => {
                        AuthStore().msg = response.data.message;
                    });
                }else {
                    AuthStore().msg = response.data.message;
                }
            })
            .catch((error) => {
                AuthStore().msg = error.response.data.message;
            });
    },

    logout(){
        Auth.logOut("/logout")
            .then((response) => {
                Cookies.remove("token");
                window.location.reload();
            })
            .catch((error) => {
                AuthStore().msg = error.response.data.message;
            });
    }
};
