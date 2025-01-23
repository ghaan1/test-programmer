import Alpine from "alpinejs";
import "../css/app.css";
import setupLogin from "./login";
import sidebar from "./sidebar";

window.Alpine = Alpine;

setupLogin();

Alpine.data("sidebar", sidebar);

Alpine.start();
