import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

if (localStorage.getItem("auth")) {
    const token = JSON.parse(localStorage.getItem("auth")).currentUser.token;
    if (token) {
        window.axios.defaults.headers.common[
            "Authorization"
        ] = `Bearer ${token}`;
    }
}
