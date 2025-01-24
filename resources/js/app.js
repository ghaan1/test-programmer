import Alpine from "alpinejs";
import "../css/app.css";
import axios from "axios";
import setupLogin from "./login";
import sidebar from "./sidebar";
import product from "./product";

window.Alpine = Alpine;

if (window.location.pathname !== "/") {
    const token = localStorage.getItem("token");

    if (token) {
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
    } else {
        window.location.href = "/";
    }
}

setupLogin();
Alpine.data("sidebar", sidebar);
Alpine.data("product", product);

Alpine.start();
