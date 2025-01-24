import Alpine from "alpinejs";
import "../css/app.css";
import axios from "axios";
import setupLogin from "./login";
import sidebar from "./sidebar";
import product from "./product";
import createProduct from "./product";

window.Alpine = Alpine;

setupLogin();
Alpine.data("sidebar", sidebar);
Alpine.data("product", product);
Alpine.data("createProduct", createProduct);

Alpine.start();
