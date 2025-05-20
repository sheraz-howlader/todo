import Auth from "../../../services/Auth.js";
import Cookies from "js-cookie";
import router from "../../../router/index.js";

export default {
    login (form_data) {
        Auth.login("/login", form_data)
            .then((response) => {
                if (response.data.success){
                    this.hasToken = response.data.token;
                    this.user =  response.data.user;

                    Cookies.set("token", response.data.token, {
                        sameSite: "lax",
                        secure: true,
                    });

                    router.push({name: 'todo'}).then(() => {
                        this.msg = response.data.message;
                    });
                }else {
                    this.msg = response.data.message;
                }
            })
            .catch((error) => {
                this.msg = error.response.data.message;
            });
    },

    logout(){
        Auth.logOut("/logout")
            .then((response) => {
                Cookies.remove("token");
                this.hasToken = false;
				router.push({ name: 'login' }).then(() => {});
            })
            .catch((error) => {
                this.msg = error.response.data.message;
            });
    }
};
