import Alpine from "alpinejs";
import "../css/app.css";
import setupLogin from "./login";

window.Alpine = Alpine;

setupLogin();
Alpine.start();
